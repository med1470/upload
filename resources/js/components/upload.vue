<template>
    <div id="app">

        <form action="" enctype="multipart/form-data"></form>
        <div id="wrapper">
            <input class="btn btn-primary" type="file" accept="application/pdf" name="" id="pdf-upload"
                   placeholder="input..." @change="fieldChange">


        </div>

        <button style="margin-left: -600px; margin-top: -60px ; width : 80px; height : 40px " class="btn btn-danger"
                @click="uploadFile"> Envoyer
        </button>
    </div>


</template>

<script>

    export default {
        data() {
            return {
                attachment: null,
            }
        },
        methods: {
            fieldChange(e) {
                console.log(e);
                let selectedFile = e.target.files[0];
                this.attachment = selectedFile;
            },
            uploadFile() {
                this.form.append('pic', this.attachment);
                const config = {headers: {'content-type': 'multipart/form-data'}}
                axios.post('/upload', this.form, config).then(response => {
                    //success
                })
                    .catch(response => {
                        //error
                    })
            },


        },
        mounted() {
            console.log('component mounted')
        }
    }


</script>
