export function permission(auth, members, user) {
  var access = false;
  var owner = false;

  var member = members && members.find(member => member.id === auth);

  if (member || user === auth) {
    access = true;
  }

  if (user === auth) {
    owner = true;
  }

  return {access, owner}
}

