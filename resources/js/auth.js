export function permission(auth, members, user) {
  var authId = auth.id;
  var member = members.find(member => member.user_id === authId);
  var accessAllowed = false;
  var ownerLogin = false;
  if (member || user.id === authId) {
    accessAllowed = true;
  }

  if (user.id === authId) {
    ownerLogin = true;
  }
  return {accessAllowed, ownerLogin}
}
