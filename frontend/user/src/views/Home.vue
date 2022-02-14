<template>
<div :style="opacity">
    <GeneralHeader>
<div class="container-fluid mt-1 p-0">
    <br/>
    <br/>
<div class="row p-0 mt-2">

    <div class="col-md-3 text-center pt-md-3 mt-2"> 
        <img src="@/assets/images/leftimg.png"  class="float-md-end mt-md-5 img-responsive" width="300" alt="">
    </div>
        <div class="col-md-6">
                <h1 class="display-5 pt-0 fw-bolder text-center">
           <strong>
               <span class="text-success">Yabatech eLibrary! <br>
             What books can I borrow?</span>
           </strong>

        </h1>
            <p class="lead mt-2 p-5 text-center text-muted">The easiest way to find books to borrow is with this eBook Lending Library which shows books that have editions available through our online Archive. </p>
    </div>
    <div class="col-md-3 mt-2 text-center">
        <img src="@/assets/images/rightimg.png" class="float-md-start mt-md-5 img-responsive" width="330" alt="">

    </div>
        <div class="col-md-12 text-center"> 
            <a href="/app/site/newaccount"><button class="btn btn-outline-primary m-2 mt-0 p-2">Create account</button> </a>
            <a href="/app/site/signin"><button class="btn btn-primary m-2 mt-0 p-2">Sign in</button> </a>
            </div>

</div>
</div>
  </GeneralHeader>
</div>
</template>
<style>

</style>
<script>

// import axios from 'axios'
export default {
    data (){
        return{
        alert: '',
        classname: '',
        record:false,
        norecord: '',
        toggle:null,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>