<template>
   <a href="" v-on:click.prevent="showPanel"><i class="far fa-user-circle"></i>
   <span>Add project</span>
</a>



</template>


<script>
    export default {
        data() {
            return {

            };
        },
        methods: {
            showPanel() {
                const panel1Handle = this.$showPanel({
                    component: 'project-form',
                    openOn: 'right',
                    width:500,
                    disableBgClick:true,
                    keepAlive:true,
                    props: {
                        //any data you want passed to your component
                    }
                })

                panel1Handle.promise
                    .then(result => {

                    });
            }
        }
    }
</script>
