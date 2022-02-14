<template>
<div :style="opacity">
<AdminHeader>
<div class="container-fluid p-0">
<div class="row">
      <div class="col-md-12 mb-1">
        <section v-if="alert!=''">
      <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
      </section>
       </div>
</div>
<div class="row p-0">
    <div class="col-md-12 mb-3">
        <h4 class="">Welcome, <span class="">{{usersession['surname']}}!</span></h4>
    </div>

    <div class="col-md-12">
<div class="">
<div class="card bg-light mb-3" style="">
  <div class="card-header">Make request<span class="float-end"></span></div>
  <div class="card-body">
      <div class="row">
          <div class="col-md-4 p-2 mb-0 rounded">
            <div class="m-2 opacity-25">
                <div class="card" style="width: 18rem;">
            <img src="../assets/images/leftimg.png" class="card-img-top m-1" alt="..." style="opacity: 0.7;">
            <div class="card-body">
            <h5 class="card-title">{{$route.params.title}}</h5>
            <p class="card-text">{{$route.params.description}}</p>
            </div>
            </div>
            </div>
<!--  -->
        </div>

          <div class="col-md-8 p-2 mb-0 rounded">
            <div class="m-2 opacity-25">
                        <form @submit.prevent="formCheck">
                      <input type="hidden" class="d-none" v-model="token" required readonly>
                      <input type="hidden" class="d-none" v-model="item_id" required readonly>
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"></legend>
            <div class="row">
            <div class="col-md-12">
                <div class="m-1">
                <div class="input-group">
                    <span class="input-group-text">Return date</span>
                    <input type="date" v-model="return_date" class="form-control" placeholder="Book title" required>
                </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="m-1">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" title="Preview" role="group" aria-label="First group">
                <button type="submit" class="btn btn-primary" :disabled="isDisabled">{{submit}}</button>
                </div>
                </div>
                </div>
            </div>
                </div>
                </fieldset>
            </form>
            </div>
          </div>

      </div>

  </div>
  <div class="card-footer">
      
     
      </div>

</div>
</div>
    </div>

</div>
</div>
</AdminHeader>
</div>
</template>

<style scoped>

</style>

<script>
import axios from 'axios'
export default {
    data (){
        return{
        auth_check: false,
        usersession: '',
        userdata:'',
        token: '',
        isToken: false,
        tryAgain: 'd-none',
        validationClass: 'text-primary',
        validationMsg: 'Please wait while validating and redirecting to the requested page...',
        alert: '',
        alertmodal: '',
        error: '',
        info: [],
        loader: false,
        loadermodal: false,
        classname: '',
        classnamemodal: null,
        submit: 'Send request',
        submittxt:'Send request',
        isDisabled: false,
        btntxt: 'Send',
        button: 'Send',
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        errormodal: null,
        record:false,
        norecord: '',
        chatMessage: '',
        item_id: this.$route.params.id,
        return_date: '',

    }
    },

   created(){
       this.usersession = this.$session.get('usersession')
        this.setStorage()
        this.checkSession()
        this.tokenize()
        },
        methods:{
tokenize: function(){
    this.$Progress.start()
    axios.get(process.env.VUE_APP_API+'/auth/token/tokenize/',{
    params:{
      'token': Math.random(9, 9999)
    }
  }).then(response => {
      if(response.data.status==response.data.statusmsg){
      this.token=response.data.key
      this.isToken=true
      this.tryAgain='d-none'
      axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.key;
      this.$Progress.finish()
      }else{
      this.$Progress.finish()
      this.isToken=false
      this.tryAgain=''
      this.validationClass = response.data.classname
      this.validationMsg=localStorage.getItem('error')
      } 
    
  }).catch(()=>{
      this.$Progress.fail()
      this.validationClass='text-danger p-2'
      this.validationMsg='Network error! refresh and try again or report this error on our contact page.'
      this.isToken=false
      this.tryAgain=''


  })
  },

            
        setStorage: function(){
        localStorage.setItem('error', this.networkerror)
        },

       checkSession: function(){
        if (this.$session.exists()) {
            this.usersession = this.$session.get('usersession')
            }else{
                return false
                }
        },

       formCheck: function(e){
        this.error_btn="";
        this.alert="";
        this.$confirm("You are about to submit this form, click Ok to continue or Cancel to go back").then(() => {
        this.submit="Please wait.."
        this.addNew()
        });
    e.preventDefault();
    },
    addNew: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        this.submit='Please wait..'
        const form = new FormData();
        form.append('item_id', this.item_id)
        form.append('return_date', this.return_date)
        form.append('userid',  this.usersession['email_one'])
        form.append('user_request_id',  this.usersession['id'])
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/form/request/addnew', form)
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        }else{
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable

        }
    }).catch(()=>{
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.submit=this.submittxt
        this.$Progress.fail()
        this.isDisabled = false
        this.opacity = this.opacity_disable

    })  
    },


preview: function(){
        this.norecord = 'Synchronizing...'
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        axios.get(process.env.VUE_APP_API+'/api/request/itemlist/',{
              params:{
                limitTo: this.displayNumber,
                userid: this.usersession['email_one'],
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.alert=''
            this.classname=''
            this.info = response.data.result
            this.counter = this.info.length
            this.record = true
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }else{
            this.record = false
            this.counter = '0'
            this.alert=''
            this.norecord=response.data.msg
            this.classname=''
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }
        
        }).catch(()=>{
            this.record = false
            this.norecord=''
            this.counter = '0'
            this.classname='alert-danger p-2'
            this.alert=localStorage.getItem('error')
            this.$Progress.fail()
            this.isDisabled = true
            this.opacity = this.opacity_disable
        })
    },

    }


    }
</script>