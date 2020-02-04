import React, { useState, useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import {
  Form,
  Input,
  Row,
  Button,
  TextArea,
  Upload,
  Icon,
  message
} from "antd";
import "antd/dist/antd.css";

const ProfileArtisan = () => {
  const { TextArea } = Input;

  const artisanSelector = useSelector(state => state.artisan);

  const [loading, setLoading] = useState(false);

  const getBase64 = (img, callback) => {
    const reader = new FileReader();
    reader.addEventListener("load", () => callback(reader.result));
    reader.readAsDataURL(img);
  };

  const beforeUpload = file => {
    const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";
    if (!isJpgOrPng) {
      message.error("You can only upload JPG/PNG file!");
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
      message.error("Image must smaller than 2MB!");
    }
    return isJpgOrPng && isLt2M;
  };

  const handleChange = info => {
    if (info.file.status === "uploading") {
      setLoading({ loading: true });
      return;
    }
    if (info.file.status === "done") {
      // Get this url from response in real world.
      getBase64(info.file.originFileObj, imageUrl =>
        setLoading({
          imageUrl,
          loading: false
        })
      );
    }
  };
  const uploadButton = (
    <div>
      <Icon type={loading ? "loading" : "plus"} />
      <div className="ant-upload-text">Upload</div>
    </div>
  );

  const { imageUrl } = loading;
  console.log("imageUrl " + imageUrl);

  return (
    <div>
      <Row type="flex" justify="space-around" align="middle">
        <Form className="artisan-form">
          <Form.Item>
            <Upload
              name="avatar"
              listType="picture-card"
              className="avatar-uploader"
              showUploadList={false}
              action="https://www.mocky.io/v2/5cc8019d300000980a055e76"
              beforeUpload={beforeUpload}
              onChange={handleChange}
            >
              {imageUrl ? (
                <img src={imageUrl} alt="avatar" style={{ width: "100%" }} />
              ) : (
                uploadButton
              )}
            </Upload>
            <Button type="primary" className="buttons" htmlType="submit">
              Confirmer
            </Button>
          </Form.Item>
          <Form.Item>
            <Input placeholder="Basic usage" value="jean" disabled={true} />
            <Input value="SIRET" disabled />
            <Input disabled value="Entreprise" />
          </Form.Item>
          <Form.Item>
            <Input disabled value="Adresse" />
            <Input disabled value="Code postal" />
            <Input disabled value="Ville" />
            <Input disabled value="Téléphone" />
            <Input disabled value="Mail" />
          </Form.Item>
          <Form.Item>
            <TextArea rows={4} />
          </Form.Item>
          <Form.Item>
            <input
              type="file"
              name="image_uploads"
              accept=".jpg, .jpeg, .png"
              multiple
            />
            <Button type="primary" className="buttons" htmlType="submit">
              Ajouter
            </Button>
            <Button type="primary" className="buttons" htmlType="submit">
              Supprimer
            </Button>
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
      </Row>
    </div>
  );
};

export default ProfileArtisan;
