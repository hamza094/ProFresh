export function canStartMeeting(meeting, auth, isAuthorized) {
    console.log(meeting, auth, isAuthorized);
  return isAuthorized && 
         meeting.owner.id === auth.id && 
         meeting.status !== 'Started';
}

export function canJoinMeeting(meeting, auth, members) {
  return meeting.owner.id !== auth.id && 
         members.includes(auth);
}