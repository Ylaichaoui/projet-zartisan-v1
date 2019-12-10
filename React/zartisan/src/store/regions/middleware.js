import { GET_REGIONS } from "src/store/regions/actions";

export default store => next => action => {
  switch (action.type) {
    /**
     * Connexion
     */
    case GET_REGIONS: {
      var data = JSON.stringify(false);
      var xhr = new XMLHttpRequest();
      xhr.withCredentials = true;
      xhr.addEventListener("readystatechange", function() {
        if (this.readyState === this.DONE) {
          console.log(this.responseText);
        }
      });
      xhr.open("GET", "http://localhost:8001/api/v1/region/list");
      xhr.setRequestHeader("content-type", "application/json");
      xhr.setRequestHeader("authorization", "Bearer " + action.cookie);
      return xhr.send(data);
    }
  }
  next(action);
};
