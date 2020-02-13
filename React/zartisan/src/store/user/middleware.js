/**
 * NAME SERVER
 */
import { NAME_SERVER } from "src/store/register/actions";
import { USER_SINGLE } from "src/store/user/actions";
import { responseUser } from "src/store/user/actions";
import axios from "axios";

export default store => next => action => {
  switch (action.type) {
    case USER_SINGLE: {
      //console.log('middleware user', action.email);
      setTimeout(() => {
        return axios({
          method: "post",
          url: `${NAME_SERVER}/v1/user/single`, // first check with static home page
          data: {
            email: action.email
          }
        })
          .then(response => {
            // console.log(response);
            if (response.status === 200) {
              //console.log('valide user', response.data);
              store.dispatch(responseUser(response.data));
            }
          })
          .catch(function(error) {
            // handle error
            // console.log(error);
          })
          .finally(function() {
            // always executed
          });
      }, 1000);
    }
  }

  next(action);
};
