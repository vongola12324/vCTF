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
                    <p class="subtitle">本題得分：{{ this.quest['point'] }}，已解人數：0</p>
                    <hr>
                    <div class="content" v-html="this.quest['content_html']"></div>
                    <a v-for="attachment in quest['attachments']" v-if="quest.hasOwnProperty('attachments')" class="button is-link" style="margin-right: 5px;" :href="attachment.url">
                        <span class="icon"><i class="far fa-download"></i></span>
                        <span>{{ attachment.filename }}</span>
                    </a>
                    <hr style="margin-top: 10px;">
                    <p v-if="isPass" class="has-text-centered has-text-info">你已經完成本題。</p>
                    <form style="display: inline" v-else>
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" type="text" placeholder="Please enter your flag.">
                            </div>
                            <div class="control">
                                <button class="button is-success" type="button" @click="submitQuest">
                                    <span class="icon"><i class="far fa-check"></i></span>
                                    <span>送出</span>
                                </button>
                            </div>
                        </div>
                    </form>
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
</style>

<script>
    export default {
        mounted: function () {
            this.quest = {
                id: this.quest_id,
                title: this.quest_title,
                point: this.quest_points,
            };
            this.fetch();
        },
        data: function() {
            return {
                isActive: false,
                questStatus: 'is-link',
                quest: '',
                flag: '',
                isPass: false,
                isFirst: true
            }
        },
        props: [
            'api',
            'submit_api',
            'quest_id',
            'quest_title',
            'quest_points'
        ],
        methods: {
            fetch: function () {
                this.$http.post(this.api, {'id': this.quest_id}).then(function (response) {
                    let res = response.body;
                    this.quest = res.data;
                    if (res.status === -1) {
                        alertify.error('獲取題目失敗')
                    }
                });
            },
            active: function () {
                this.isActive = true;
            },
            inactive: function () {
                this.isActive = false;
            },
            submitQuest: function () {
                this.$http.post(this.submit_api, {'quest': this.quest_id, 'flag': '12345', 'csrf-token': document.head.querySelector('meta[name="csrf-token"]').content}).then(function (response) {
                    let data = response.body.data;
                    if (data.correct === true) {
                        this.isPass = true;
                        if (data.first === true) {
                            this.isFirst = true;
                        }
                        this.updateStatus();
                    }
                });
            },
            updateStatus: function () {
                if (this.isPass) {
                    this.questStatus = 'is-primary';
                    if (this.isFirst) {
                        // Do nothing now
                    }
                }
            }
        }
    }
</script>
