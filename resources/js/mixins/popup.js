export default{

methods: {
  handleClickOutside(event, popup, isPop) {
    if (!event.target.closest(popup)) {
      isPop = false;
      document.removeEventListener('click', (event) => this.handleClickOutside(event, popup, isPop));
    }
  }
}
}