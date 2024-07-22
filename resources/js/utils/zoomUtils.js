import axios from 'axios';
import ZoomMtgEmbedded from '@zoom/meetingsdk/embedded';

export async function getToken(url, errorMessage, toastify) {
  try {
    const response = await axios.get(url);
    return response.data;
  } catch (error) {
    toastify.error(errorMessage);
    throw error;
  }
}

export async function fetchTokens(action, role, meetingId, toastify) {
  return await Promise.all([
    action === 'start' ? getToken('/api/v1/user/token', 'Unable to generate ZAK token', toastify) : Promise.resolve(null),
    getToken(`/api/v1/user/jwt/token?role=${role}&meetingId=${meetingId}`, 'Unable to generate JWT token', toastify)
  ]);
}

export async function setupAndJoinMeeting(action, meeting, jwt_token, zak_token, auth) {
  const client = ZoomMtgEmbedded.createClient();

  const meetingSDKElement = document.getElementById('meetingSDKElement');
  client.init({
    zoomAppRoot: meetingSDKElement,
    language: 'en-US',
  });

  const meetingConfig = {
    sdkKey: process.env.MIX_ZOOM_SDK_KEY,
    signature: jwt_token,
    meetingNumber: meeting.meeting_id,
    password: meeting.password,
    userName: auth.name,
  };

  if (action === 'start') {
    meetingConfig.zak = zak_token;
  }

  await client.join(meetingConfig);
}