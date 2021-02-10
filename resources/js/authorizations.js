let user=window.App.user;
module.exports={
    projectOwner(project){
        return project.user_id === user.id;
    },
    profileOwner(owner){
        return owner.id === user.id;
    },
};
