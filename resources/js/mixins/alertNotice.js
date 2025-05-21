import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default{
    methods:{

  sweetAlert($message){
    return Swal.fire({
      title: 'Are you sure?',
      text: "You can be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: $message
    })
   },

   performAction($message,$axiosCall){
     var self=this;
    this.sweetAlert($message).then((result) => {
    if (result.value) {
     $axiosCall.
     then(response=>{
       this.$vToastify.success(response.data.message);
      self.$router.push('/dashboard');
     }).catch(error=>{
       Swal.fire("Failed!","There was something wrong.","warning");
      });
    }
   })
   }

    }
}
