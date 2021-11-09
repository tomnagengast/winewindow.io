<template>
    <div>
        <input :id="id" type="hidden" :value="trixText">
        <trix-editor :input="id" :placeholder="placeholder"></trix-editor>
    </div>

<!--    <script>-->
<!--        const element = document.querySelector("trix-editor");-->
<!--        const actions = {-->
<!--            decreaseNestingLevel: false,-->
<!--            increaseNestingLevel: false-->
<!--        }-->
<!--        element.editor.element.editorController.toolbarController.updateActions(actions);-->
<!--    </script>-->
</template>

<script>
import Trix from 'trix'
import 'trix/dist/trix.css'

export default {
    props: ["id", "content", "placeholder"],
    data() {
        return {
            trixText: this.content,
        };
    },
    methods: {
        setTextToTrix(e) {
            this.trixText = document.getElementById(this.id).value;
        },
        emitDataBackToComponent() {
            this.$emit("dataFromTrix", this.trixText);
        },
    },
    mounted() {
        document.addEventListener("trix-change", this.setTextToTrix);
    },
    beforeDestroy: function() {
        document.removeEventListener("trix-change", this.setTextToTrix);
    },
    updated() {
        this.emitDataBackToComponent();
    },
};
</script>
