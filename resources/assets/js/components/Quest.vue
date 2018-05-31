<template>
    <div class="is-2 column">
        <article :class="['tile', 'is-child', 'notification', questStatus ]" @click="active">
            <div class="corner" v-if="isFirst">
                <i class="far fa-crown"></i>
            </div>
            <p class="title">{{ this.quest['title'] }}</p>
            <p class="subtitle">{{ this.quest['point'] }}</p>
        </article>
        <div :class="['modal', {'is-active': isActive}]">
            <div class="modal-background" @click="inactive"></div>
            <div class="modal-content">
                <div class="box">
                    <p class="is-1 title">{{ this.quest['title'] }}</p>
                    <p class="subtitle">本題得分：{{ this.quest['point'] }}，解答狀況：{{ this.solved }} / {{ this.total }}</p>
                    <hr>
                    <div class="content" v-html="this.quest['content_html']"></div>
                    <a v-for="attachment in quest['attachments']" v-if="quest.hasOwnProperty('attachments')" class="button is-link" style="margin-right: 5px;" :href="attachment.url">
                        <span class="icon"><i class="far fa-download"></i></span>
                        <span>{{ attachment.filename }}</span>
                    </a>
                    <hr style="margin-top: 10px;">
                    <p v-if="isPass" class="has-text-centered has-text-info">你已經完成本題。</p>
                    <div style="display: inline" v-else>
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" type="text" placeholder="Please enter your flag." :id="this.inputId">
                            </div>
                            <div class="control">
                                <button class="button is-success" type="button" @click="submitQuest">
                                    <span class="icon"><i class="far fa-check"></i></span>
                                    <span>送出</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="notification is-danger" v-if="isFailed" style="margin-top: 20px;">
                        <p class="has-text-centered has-text-weight-bold">Wrong Flag!</p>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click.prevent="inactive"></button>
        </div>
    </div>
</template>

<style>
    .corner {
        position: absolute;
        top: 0;
        right: auto;
        left: 0;
        margin: 0;
        padding: 0;
        text-align: center;
        border-color: gold;
        width: 4em;
        height: 4em;
        z-index: 1;
        -webkit-transition: border-color .1s ease;
        transition: border-color .1s ease;
        background-color: transparent !important;
        color: rgba(0, 0, 0, 0.6);
    }
    .is-correct {
        background-color: #00d1b2;
        color: #fff;
    }

    .is-first {
        background-color: goldenrod;
        color: #fff;
    }
</style>

<script>
    export default {
        mounted: function () {
            this.quest = {
                id: this.quest_id,
                title: this.quest_title,
                point: this.quest_points,
            };
            this.getData();
        },
        data: function() {
            return {
                isActive: false,
                questStatus: 'is-link',
                quest: '',
                flag: '',
                inputId: 'input_' + this.quest_id,
                isPass: false,
                isFirst: true,
                solved: 0,
                total: 0,
                isFailed: false,
            }
        },
        props: [
            'data_api',
            'status_api',
            'submit_api',
            'quest_id',
            'quest_title',
            'quest_points'
        ],
        methods: {
            getData: function () {
                this.$http.post(this.data_api, {'id': this.quest_id, 'csrf-token': document.head.querySelector('meta[name="csrf-token"]').content}).then(function (response) {
                    let res = response.body;
                    if (res['status'] === -1) {
                        alertify.error(res['msg']);
                    } else {
                        let data = res.data;
                        this.quest = data['quest'];
                        this.solved = parseInt(data['status']['solved']);
                        this.total = parseInt(data['status']['total']);
                        this.isPass = data['status']['is_correct'];
                        this.isFirst = data['status']['is_first'];
                        this.updateStatus();
                    }
                });
            },
            active: function () {
                this.isActive = true;
            },
            inactive: function () {
                this.isActive = false;
                this.isFailed = false;
            },
            submitQuest: function () {
                let input = $('#' + this.inputId);
                this.isFailed = false;
                this.$http.post(this.submit_api, {'quest': this.quest_id, 'flag': input.val(), 'csrf-token': document.head.querySelector('meta[name="csrf-token"]').content}).then(function (response) {
                    let res = response.body;
                    if (res['status'] === -1) {
                        alertify.error(res['msg']);
                    } else {
                        let data = res.data;
                        if (data['is_correct'] === true) {
                            this.isPass = true;
                            if (data['is_first'] === true) {
                                this.isFirst = true;
                            }
                            this.updateStatus();
                        } else {
                            this.isFailed = true;
                        }
                    }
                    input.val('');
                });
            },
            updateStatus: function () {
                if (this.isPass) {
                    this.questStatus = 'is-correct';
                    if (this.isFirst) {
                        this.questStatus = 'is-first';
                    }
                }
            }
        }
    }
</script>