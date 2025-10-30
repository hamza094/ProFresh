export function shouldShowStartButton(meeting, auth, notAuthorize) {
    return !notAuthorize && meeting.owner.id === auth.id && meeting.status.toLowerCase() !== 'started';
}

export function shouldShowJoinButton(meeting, auth, members) {
    return meeting.owner.id !== auth.id && members.includes(auth);
}