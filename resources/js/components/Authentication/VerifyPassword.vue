<template>
	<div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="form">
                <div class="card-title">Account Verification</div>
								<div class="card-body" v-if="success">
									<h5>Congratulations! Your Account has been verified Successfully.
										Please log in to continue </h5>
								</div>
								<div class="card-body" v-else-if="error == 'verification.already_verified'">
									<h5>Account already verified. Please log in to continue</h5>
								</div>
								<div class="card-body" v-else>
									<h5>Verification Error. Please log in to get the verified link again </h5>
								</div>
            </div>
        </div>
    </div>
</div>
    </div>
</template>

<script>
 const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')
 export default {
	 async beforeRouteEnter (to, from, next) {
	   try {
	     const { data } = await axios.post(`/api/v1/email/verify/${to.params.id}?${qs(to.query)}`)
	     next(vm => { vm.success = data.status })
	    } catch (e) {
	      next(vm => { vm.error = e.response.data.status })
	    }
	  },
		data: () => ({
	error: '',
	success: ''
})
}

</script>
