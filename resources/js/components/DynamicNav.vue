<template>
    <div class="vue-dropdown" @click="isOpen = !isOpen">
       <!-- trigger -->
        <slot name="trigger"></slot>
        
        <!-- menu links -->
        <div class="vue-dropdown_item" v-show=isOpen>
            <slot></slot>
        </div> 
    </div>
</template>

<script>
export default{
    data(){
        return{
            isOpen:false
        }
    },
        watch:{
        isOpen(isOpen){
            if(isOpen){
                document.addEventListener('click',this.closeIfClickedOutside);
            }
        }
    },
    methods:{
        closeIfClickedOutside(event){
            if(!event.target.closest('.vue-dropdown')){
                this.isOpen=false;
                document.removeEventListener('click',this.closeIfClickedOutside);
            }
        }
    }
}


</script>