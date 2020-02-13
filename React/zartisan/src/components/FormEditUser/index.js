import React from "react";
import { Form, Input, Button } from "antd";
import UploadAvatar from "../UploadAvatar";
import "antd/dist/antd.css";

const FormEditUser = () => {
  return (
    <Form className="artisan-form">
      <Form.Item>
        <UploadAvatar />
      </Form.Item>

      <Form.Item label="Pseudo" hasFeedback>
        <Input placeholder="Pseudo" />
      </Form.Item>

      <Form.Item label="Nom" hasFeedback>
        <Input placeholder="Nom" />
      </Form.Item>

      <Form.Item label="Prénom" hasFeedback>
        <Input placeholder="Prénom" />
      </Form.Item>

      <Form.Item label="Téléphone" hasFeedback>
        <Input placeholder="Téléphone" />
      </Form.Item>

      <Form.Item label="Mail" hasFeedback>
        <Input placeholder="Mail" />
      </Form.Item>

      <Form.Item>
        <Button type="primary" className="buttons" htmlType="submit">
          Sauvegarder
        </Button>
      </Form.Item>
      <Form.Item>
        <Button type="danger" htmlType="submit">
          Supprimer le compte
        </Button>
      </Form.Item>
    </Form>
  );
};

export default FormEditUser;
