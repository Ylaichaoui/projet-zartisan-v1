export const USER_SINGLE = "search/actions/USER_SINGLE";

export const userSingle = email => ({
  type: USER_SINGLE,
  email
});

export const RESPONSE_USER = "search/actions/RESPONSE_USER";

export const responseUser = data => ({
  type: RESPONSE_USER,
  data
});
