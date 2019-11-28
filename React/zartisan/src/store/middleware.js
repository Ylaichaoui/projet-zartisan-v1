export default store => next => action => {
  console.log('middleware', action);

  // switch(action.type) {
  //   case UNE_ACTION: {
  //     // ...
  //   }
  // }

  next(action);
};
