<template>
    <div class="is-2 column">
        <article :class="['tile', 'is-child', 'notification', questStatus ]" @click="active">
            <div class="corner" v-if="isFirst">
                <i class="far fa-crown"></i>
            </div>
            <p class="is-4 title">{{ this.quest['title'] }}</p>
            <p class="is-4 subtitle">{{ this.quest['point'] }} {{ this.quest['point'] | pluralize('point')}}</p>
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
                    <template v-if="Object.keys(this.unlockHints).length > 0 && !isPass">
                        <hr style="margin-top: 10px; margin-bottom: 10px;">
                        <h3 class="title is-4" style="margin-bottom: 5px;">本題有提示：</h3>
                        <ul :id="this.quest_id + '_hint_list'" style="margin-bottom: 5px;list-style: disc;padding-left: 2em;">
                            <li v-for="hint in unlockHints" v-if="hint.content !== null">
                                {{ hint.content }}
                            </li>
                        </ul>
                        <button v-for="hint in unlockHints" v-if="hint.content === null" class="button is-warning" style="margin-right: 5px;" @click="unlockHint(hint.id)" :id="'unlock_hint_' + hint.id">
                            <span class="icon"><i class="far fa-unlock"></i></span>
                            <span v-if="hint.point === 0">Unlock Hint</span>
                            <span v-else>Unlock Hint (-{{ hint.point }})</span>
                        </button>
                    </template>
                    <hr style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="notification is-primary" v-if="isPass" style="padding-top: 10px;padding-bottom: 10px;">
                        <p class="has-text-centered has-text-weight-bold">你已經完成本題。</p>
                    </div>
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
                    <div class="notification is-danger" v-if="isFailed" style="margin-top: 10px;padding-top: 10px;padding-bottom: 10px;">
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
        padding: 0 0 0 5px;
        border-color: gold;
        width: 4em;
        height: 4em;
        z-index: 1;
        -webkit-transition: border-color .1s ease;
        transition: border-color .1s ease;
        background-color: transparent !important;
        color: gold;
    }
    .is-correct {
        background-color: #00d1b2;
        color: #fff;
    }

    .is-first {
        background-color: #00d1b2;
        color: #fff;
    }
</style>

<script>
    import Vue2Filters from 'vue2-filters';

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
                unlockHints: []
            }
        },
        components: {
            Vue2Filters
        },
        props: [
            'data_api',
            'status_api',
            'submit_api',
            'hint_api',
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
                        this.unlockHints = data['unlock_hints'];
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
            unlockHint: function (id) {
                var that = this;
                this.$http.post(this.hint_api, {'quest': this.quest_id, 'hint': id, 'csrf-token': document.head.querySelector('meta[name="csrf-token"]').content}).then(function (response) {
                    let res = response.body;
                    if (res['status'] === -1) {
                        alertify.error(res['msg']);
                    } else {
                        let data = res.data;
                        $('ul#'+ that.quest_id +'_hint_list').append('<li>'+ data.content + '</li>');
                        $('button#unlock_hint_' + id).remove();
                    }
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
