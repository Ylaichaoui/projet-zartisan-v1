export const ALERT_ADVICE = "advice/actions/ALERT_ADVICE";

export const alertAdvice = id => ({
  type: ALERT_ADVICE,
  id
});

export const ALERT_SUCCESS = "advice/actions/ALERT_SUCCESS";

export const alertSuccess = response => ({
  type: ALERT_SUCCESS,
  response
});

export const SEND_ADVICE = "advice/actions/SEND_ADVICE";

export const sendAdvice = (mail, idArtisan, body) => ({
  type: SEND_ADVICE,
  mail,
  idArtisan,
  body
});

export const ADVICE = "advice/actions/ADVICE";

export const advice = () => ({
  type: ADVICE
});
