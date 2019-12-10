<<<<<<< HEAD
import axios from "axios";
import { GET_REGIONS } from "src/store/regions/actions";
import { regions } from "src/store/regions/actions";
=======
import { GET_REGIONS } from "src/store/regions/actions";
import axios from "axios";
>>>>>>> 053223ab25d91cb3e3a41cbf2a4809de14b16359

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
<<<<<<< HEAD
          //console.log(response);
          if (response.status === 200) {
            //console.log("region");
            //console.log(response.data);
            store.dispatch(regions(response.data));
            // store.getState();
            // store.storeReducer();
            // store.liftedStore();
=======
          console.log(response);
          if (response.status === 200) {
            console.log("region");
>>>>>>> 053223ab25d91cb3e3a41cbf2a4809de14b16359
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
