import React, { useState, useEffect } from "react";
import { Form, Icon, Input, Button } from "antd";
import "antd/dist/antd.css";
import "./style.sass";
import { Link } from "react-router-dom";
import { withRouter } from "react-router-dom";
import cookies from "js-cookie";

const FormLogin = ({ handleSubmitLogin, handleCancel }) => {
  // let artisanSelector = useSelector((state) => state.artisan);
  //console.log('burger', artisanSelector);
  // let token = cookies.get('TOKEN');

  // let parseJwt = (token) => {
  // 	try {
  // 		return JSON.parse(atob(token.split('.')[1]));
  // 	} catch (e) {
  // 		return null;
  // 	}
  // };

  // let tokenEmail = '';
  // let admin = '';
  // let artisanUser = -1;
  // if (token != null) {
  // 	admin = parseJwt(token).roles[0];
  // 	artisanUser = parseJwt(token).roles.indexOf('ROLE_ARTISAN');
  // 	tokenEmail = parseJwt(token).username;
  //console.log(tokenEmail);
  //console.log(parseJwt(token).roles[0]);
  // }

  // let dataArtisan = '';
  // if (artisanUser != -1) {
  // 	dataArtisan = artisanSelector[0].company;
  // }

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const mailChangeValue = event => {
    //console.log(event.target.value);
    setEmail(event.target.value);
  };
  //console.log(email);
  const passwordChangeValue = event => {
    //console.log(event.target.value);
    setPassword(event.target.value);
  };

  const ButtonLogin = () => {
    return (
      <Button
        type="default"
        className="buttons"
        htmlType="submit"
        className="login-form-button"
        style={{ color: "white", background: "#bb9574" }}
      >
        Se connecter
      </Button>
    );
  };

  return (
    <div>
      <Form method="POST" onSubmit={handleSubmitLogin(email, password)}>
        <Form.Item>
          <Input
            onChange={mailChangeValue}
            prefix={<Icon type="mail" style={{ color: "rgba(0,0,0,.25)" }} />}
            placeholder="Email"
            required
          />
          <Input
            onChange={passwordChangeValue}
            prefix={<Icon type="lock" style={{ color: "rgba(0,0,0,.25)" }} />}
            type="password"
            placeholder="Mot de passe"
            required
          />
          <Link
            className="login-form-forgot"
            to="/mot-de-passe-oublié"
            onClick={handleCancel}
          >
            Mot de passe oublié
          </Link>
        </Form.Item>
        <ButtonLogin />
      </Form>
    </div>
  );
};

export default FormLogin;
