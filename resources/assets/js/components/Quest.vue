<template>
    <div class="is-2 column">
        <article :class="['tile', 'is-child', 'notification', questStatus ]" @click="active">
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
                    <form action=""></form>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click.prevent="inactive"></button>
        </div>
    </div>
</template>

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
            }
        },
        props: [
            'api',
            'quest_id',
            'quest_title',
            'quest_points'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api).then(function (response) {
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
            hasAttachment: function () {
                console.log(this.quest.attachments.length);
                return this.quest.hasOwnProperty('attachments') && this.quest.attachments.length > 0;
            }
        }
    }
</script>
