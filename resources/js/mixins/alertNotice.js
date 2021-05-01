export default{
    methods:{

  sweetAlert($action){
    return swal.fire({
      title: 'Are you sure?',
      text: "You can be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: $action
    })
   },

  redirectSuccess($message,$redirect){
     swal.fire(
       'Success!',
        $message,
        'success'
        )
        setTimeout(()=>{
             window.location.href=$redirect;
        },3000)
   }
   
    }
}