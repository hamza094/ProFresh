<template>
    <div class="container-fluid ">
<div class="row">
    <div class="col-md-8 page pd-r">
        <div class="page-top">
        <div>
            <span>
                <span class="page-top_heading">Leads </span>
                <span class="page-top_arrow"> > </span>
                <span> {{lead.name}}</span>
            </span>
            <div class="float-right">
                buttons
            </div>
        </div>
        </div>
<div class="page-content">
    <div class="row">
    <div class="col-md-2">
        <div class="hexa">
        <div class="hex1">
            <div class="hex2">
                <img src="https://i.pinimg.com/originals/a4/df/b3/a4dfb30dab46881c9be128bea6ca4762.jpg" alt=""
                     width="125" height="130"  @click="showPanel"/>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="content">
        <p class="content-name">Jane Simpleton</p>
            <p class="content-info">Sales Manager<span class="content-dot"></span>Widjets.co</p>
            <p class="content-map"><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q=1200 Pennsylvania Ave SE, Washington, District of Columbia, 20003" target="_blank">Mongolia, Usa</a></p>
        </div>
 </div>
    </div>
</div>
    </div>
    <div class="col-md-4">
        by
    </div>
</div>
    </div>
</template>

<script>
export default{
props:['lead'],
    data(){
    return{

    }
    },
    methods:{
        showPanel() {
            const panel1Handle = this.$showPanel({
                component: 'file',
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
