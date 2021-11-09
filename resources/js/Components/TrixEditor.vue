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
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    props: ["id", "content", "placeholder"],
    data() {
        return {
            trixText: this.content,
            host: 'https://d13txem1unpe48.cloudfront.net/'
        };
    },
    methods: {
        setTextToTrix(e) {
            this.trixText = document.getElementById(this.id).value;
        },
        emitDataBackToComponent() {
            this.$emit("dataFromTrix", this.trixText);
        },


        addTrixAttachment(e) {
            console.log('Uploading image attachment')
            if (e.attachment.file) {
                // this.uploadFileAttachment(e.attachment)
            }
        },
        uploadFileAttachment(attachment) {
            this.uploadFile(attachment.file, setProgress, setAttributes)

            function setProgress(progress) {
                attachment.setUploadProgress(progress)
            }

            function setAttributes(attributes) {
                attachment.setAttributes(attributes)
            }
        },
        uploadFile(file, progressCallback, successCallback) {
            const key = this.createStorageKey(file)
            const formData = this.createFormData(key, file)
            const xhr = new XMLHttpRequest()

            xhr.open("POST", this.host, true)

            xhr.upload.addEventListener("progress", function(event) {
                const progress = event.loaded / event.total * 100
                progressCallback(progress)
            })

            xhr.addEventListener("load", function(event) {
                if (xhr.status === 204) {
                    const attributes = {
                        url: this.host + key,
                        href: this.host + key + "?content-disposition=attachment"
                    }
                    successCallback(attributes)
                }
            })

            xhr.send(formData)
        },
        createStorageKey(file) {
            const date = new Date()
            const day = date.toISOString().slice(0,10)
            const name = date.getTime() + "-" + file.name
            return [ "tmp", day, name ].join("/")
        },
        createFormData(key, file) {
            const data = new FormData()
            data.append("key", key)
            data.append("Content-Type", file.type)
            data.append("file", file)
            return data
        },

        removeTrixAttachment(e) {
            console.log('Removing image attachment')
        },
    },
    mounted() {
        document.addEventListener("trix-change", this.setTextToTrix);
        document.addEventListener("trix-attachment-add", this.addTrixAttachment);
        document.addEventListener("trix-attachment-remove", this.removeTrixAttachment);
    },
    beforeDestroy: function() {
        document.removeEventListener("trix-change", this.setTextToTrix);
    },
    updated() {
        this.emitDataBackToComponent();
    },
};
</script>
