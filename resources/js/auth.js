export function permission(auth, members, user,isAdmin) {
  const access = members && members.some(member => member.id === auth) || user === auth || isAdmin;
  const owner = user === auth;

  return { access, owner };
}

export function admin(isAdmin) {
  return { access: isAdmin };
}