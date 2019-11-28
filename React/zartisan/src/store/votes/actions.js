export const actions = {
  VOTE_OUI: 'votes/action/VOTE_OUI',
  VOTE_NON: 'votes/action/VOTE_NON',
  RESET_VOTES: 'votes/action/RESET_VOTES'
};

export const vote = (voteType) => ({
  // eval permet d'exécuter du code écrit dans une chaîne de caractère.
  // cf. https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/eval
  // C'est un outil puissant mais dangereux ! Ici, c'est acceptable car le
  // reducer va sécuriser le traitement des actions.
  type: eval(`actions.VOTE_${voteType.toUpperCase()}`)
});

export const resetVotes = () => ({
  type: actions.RESET_VOTES
});
