<template>
<a v-on:click.prevent="showPanel" class="panel-list_item">
<p><span class="icon"><i class="icon-logo fas fa-plus-circle"></i><span class="icon-name">New Project</span></span></p>
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
