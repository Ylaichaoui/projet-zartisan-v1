import { GET_REGIONS } from "src/store/regions/actions";
import axios from "axios";

export default store => next => action => {
  switch (action.type) {
    /**
     * Connexion
     */
    /**
     * Artisan register
     */
    case GET_REGIONS: {
      return axios({
        method: "get",
        url: "http://localhost:8001/v1/region/list"
      })
        .then(response => {
          console.log(response);
          if (response.status === 200) {
            console.log("region");
          }
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    }
  }
  next(action);
};
