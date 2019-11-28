import React from 'react';
import { connect } from 'react-redux';

import { vote, resetVotes } from 'src/store/votes/actions';


// Stratégie de lecture depuis le state global de l'application.
// La fonction de sélection a pour rôle unique de lire de l'information
// depuis le state global.
const mapStateToProps = (state) => {
  const { question, oui, non } = state.votes;
  // Ici, la fonction select pourrait appliquer des traitements sur les données
  // récupérées dans le state global.
  return {
    question,
    oui,
    non,
    total: oui + non
  };
};

// Stratégie d'écriture dans le state global de l'application.
// La fonction dispatchers retourne un objet, chaque propriété va devenir
// un prop passée à un composant de présentation qui pourra utiliser les
// fonctions définies pour déclencher des dispatch().
const mapDispatchToProps = (dispatch) => {
  // Code business (spécifique à l'application de vote);
  return {
    // vote : fonction-usine qui prépare des gestionnaires de clic pour voter
    // sur telle ou telle réponse.
    vote: (voteType) => {
      // La fonction vote crée et retourne des fonctions-handler qui seront
      // branchées sur onClick de différents boutons de vote.
      return (event) => {
        dispatch(vote(voteType));
      };
    },
    reset: (event) => {
      dispatch(resetVotes());
    }
  };
};

// Composant de présentation.
const VoteWidget = ({
  question,
  oui,
  non,
  total,
  vote,
  reset
}) => {
  return <div className="vote-widget">
    <p>{question} (votes : {total})</p>
    <button onClick={vote('oui')}>oui ({oui})</button>
    <button onClick={vote('non')}>non ({non})</button>
    <button onClick={reset}>RESET</button>
  </div>;
};

// Le composant de présentation VoteWidget a besoin de props. On génère un
// composant container capable de préparer ces props en utilisant les logiques
// de lecture / écriture dans le store, implémentées avec les fonctions
// select et dispatchers respectivement.
const VoteWidgetContainer = connect(
  mapStateToProps,
  mapDispatchToProps
)(VoteWidget);

// C'est le composant container qui est exporté et qui sera instancié, et il
// instanciera en cascade le composant de présentation en l'alimentant avec
// les props dont il a besoin.
export default VoteWidgetContainer;
