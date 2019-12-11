export const SEND_REGISTER_USER = "register/actions/SEND_REGISTER_USER";

export const sendRegisterUser = (email, password) => ({
  type: SEND_REGISTER_USER,
  email,
  password
});


export const SEND_REGISTER_ARTISAN = "register/actions/SEND_REGISTER_ARTISAN";

export const sendRegisterArtisan = (email, password, siret) => ({
  type: SEND_REGISTER_ARTISAN,
  email,
  password,
  siret
});

export const SEND_LOGIN = "register/actions/SEND_LOGIN";

export const sendLogin = (email, password) => ({
  type: SEND_LOGIN,
  username: email,
  password
});

export const CONNECT = "register/actions/CONNECT";

export const DECONNEXION = "register/actions/DECONNEXION";

export const deconnect = () => ({
  type: DECONNEXION

});
