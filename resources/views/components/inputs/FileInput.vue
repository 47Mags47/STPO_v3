<script>
import BaseButton from "../buttons/BaseButton.vue";
import BlueButton from "../buttons/BlueButton.vue";
import Ico from "../icons/Ico.vue";

export default {
    components: { Ico, BaseButton, BlueButton },
    props: {
        name: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            default(props) {
                return props.name;
            },
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        accept: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: "Файл не выбран",
        },
        buttonText: {
            type: String,
            default: "Выбрать файл",
        },
    },

    data() {
        return {
            internalFiles: null,
        };
    },

    computed: {
        fileLabel() {
            if (!this.internalFiles) return this.placeholder;

            if (Array.isArray(this.internalFiles)) {
                return this.internalFiles.map((f) => f.name).join(", ");
            }

            return this.internalFiles.name;
        },
    },

    methods: {
        trigger() {
            this.$refs.input.click();
        },

        handleChange(e) {
            const files = this.multiple
                ? Array.from(e.target.files)
                : e.target.files[0] || null;

            this.internalFiles = files;
        },

        clear() {
            this.$refs.input.value = "";
            this.internalFiles = null;
        },
    },
};
</script>

<template>
    <div class="file-input-wrapper">
        <input
            ref="input"
            type="file"
            :id="id"
            :name="name"
            :multiple="multiple"
            :accept="accept"
            class="native-input"
            @change="handleChange"
        />

        <div class="file-display">
            <span
                class="file-text"
                :title="internalFiles ? fileLabel : ''"
                @click="trigger"
            >
                {{ fileLabel }}
            </span>

            <div class="actions">
                <BaseButton
                    v-if="internalFiles"
                    type="button"
                    class="clear-btn"
                    @click.stop="clear"
                >
                    <Ico type="x" />
                </BaseButton>

                <BlueButton class="select-btn" @click.stop="trigger">
                    {{ buttonText }}
                </BlueButton>
            </div>
        </div>
    </div>
</template>

<style scoped lang="sass">
.file-input-wrapper
    width: 100%

    .native-input
        display: none

    .file-display
        display: flex
        align-items: center
        justify-content: space-between
        gap: 4px
        padding: 0 6px
        border: $input-border
        border-radius: $input-border-radius
        background: white
        height: 30px
        line-height: 30px
        font-size: 13px
        overflow: hidden

    .file-text
        flex: 1 1 auto
        min-width: 0
        overflow: hidden
        text-overflow: ellipsis
        white-space: nowrap
        cursor: pointer
        font-size: 13px
        line-height: 30px
        padding-right: 4px

    .actions
        display: flex
        align-items: center
        gap: 4px
        flex-shrink: 0

    .select-btn
        width: 100px
        padding: 2px 6px
        font-size: 11px
        min-height: 24px

    .clear-btn
        width: 20px
        height: 20px
        padding: 0
        display: flex
        align-items: center
        justify-content: center
        background: none
        border: none
        color: #888
        cursor: pointer

        &:hover
            color: #e11d48
</style>
