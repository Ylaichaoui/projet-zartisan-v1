import { RESPONSE_USER } from "src/store/user/actions";

const initialState = "";

export default (state = initialState, action) => {
  //console.log('reducer >>', action);

  switch (action.type) {
    case RESPONSE_USER: {
      //console.log('action reducer user', action.data);
      return (state = action.data);
    }
    default: {
      return state;
    }
  }
};
