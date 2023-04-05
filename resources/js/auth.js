export function permission(auth, members, user) {
  var authId = auth.id;
  var access = false;
  var owner = false;
  var member = members.find(member => member.id === authId);
  if (member || user.id === authId) {
    access = true;
  }

  if (user.id === authId) {
    owner = true;
  }
  return {access, owner}
}
