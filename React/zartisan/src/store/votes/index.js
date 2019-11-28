import { votes as actions } from 'src/store/actions';

const initialState = {
  title: 'Bonjour',
  results: {},
  question: "Pour ou contre la congolemexicalisation ?",
  oui: 0,
  non: 0
};

export default (state = initialState, action) => {
  console.log('reducer[votes] >>', action);

  switch(action.type) {
    case actions.VOTE_OUI: {
      const newState = { ...state, oui: state.oui + 1 };
      return newState;
    }
    case actions.VOTE_NON: {
      return { ...state, non: state.non + 1 };
    }
    case actions.RESET_VOTES: {
      return { ...state, oui: 0, non: 0 };
    }
    default: {
      return state;
    }
  }
}
