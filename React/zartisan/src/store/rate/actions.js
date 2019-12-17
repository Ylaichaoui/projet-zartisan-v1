export const SEND_RATE = "rate/actions/SEND_RATE";

export const sendRate = (id, mail, value) => ({
  type: SEND_RATE,
  id,
  mail,
  value
});

export const RATE = "rate/actions/RATE";

export const rate = averageRate => ({
  type: RATE,
  averageRate
});
