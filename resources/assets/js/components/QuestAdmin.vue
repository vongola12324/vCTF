<template>
    <div class="is-2 column">
        <article class="tile is-child notification is-warning" @click="active">
            <p class="title">Title</p>
            <p class="subtitle">Test</p>
        </article>
        <div :class="['modal', {'is-active': isActive}]">
            <div class="modal-background" @click="inactive"></div>
            <div class="modal-content">
                <div class="box">
                    <p>
                        Quest # {{ quest_id }}
                    </p>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click.prevent="inactive"></button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                isActive: false
            };
        },
        props: [
            'quest_id'
        ],
        methods: {
            active: function () {
                this.isActive = true;
            },
            inactive: function () {
                this.isActive = false;
            }

        }
    }
</script>
