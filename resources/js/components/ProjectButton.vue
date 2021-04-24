<template>
 <span role="button" class="nav-btn" v-on:click.prevent="showPanel">+</span>
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
