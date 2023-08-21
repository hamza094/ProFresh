import moment from 'moment';

export function calculateRemainingTime(task, currentDate) {
  if (task.due_at !== null) {
    const duration = moment.duration(moment(task.due_at).diff(moment(currentDate)));

    if (duration.asMilliseconds() <= 0) {
      return 'Due date passed';
    }

    const days = duration.days();
    const hours = duration.hours();
    const minutes = duration.minutes();

    const messageParts = [];
    if (days > 0) {
      messageParts.push(`${days} day(s)`);
    }
    if (hours > 0) {
      messageParts.push(`${hours} hour(s)`);
    }
    if (minutes > 0) {
      messageParts.push(`${minutes} minute(s)`);
    }

    return `${messageParts.join(', ')} remaining`;
  }
}

export function url($slug,$id){
      return '/api/v1/projects/'+$slug+'/tasks/'+$id;
}

/*export function updateTask(slug, id, task, data, additionalCallback) {
  if (areObjectsEqual(data, task)) {
    this.$vToastify.warning("Update not allowed. No changes were made.");
    return;
  }

  axios.put(url(slug, id), data)
    .then(response => {
      this.$vToastify.success(response.data.message);
      if (additionalCallback) {
        additionalCallback(response.data); // Call additional callback if provided
      }
    })
    .catch(error => {
      console.logerror.response.data.errors;
    });
}

export function areObjectsEqual(obj1, obj2) {
  return Object.keys(obj1).every(key => obj1[key] === obj2[key]);
}*/
