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
  message,
  Modal
} from "antd";
import "antd/dist/antd.css";
import { artisanEdit } from "src/store/artisan/actions";
import { NAME_SERVER } from "src/store/register/actions";

const ProfileArtisan = () => {
  const dispatch = useDispatch();

  const { TextArea } = Input;

  const artisanSelector = useSelector(state => state.artisan);
  //console.log(artisanSelector);

  let artisanObject = {};
  for (let artisan in artisanSelector) {
    //console.log(artisanSelector[artisan]);
    artisanObject = artisanSelector[0];
  }
  console.log("object", artisanObject);

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
      getBase64(info.file.originFileObj, imageUrl => {
        setPictureAvatar(imageUrl);
        return setLoading({
          imageUrl,
          loading: false
        });
      });
    }
  };

  const uploadButton = (
    <div>
      <Icon type={loading ? "loading" : "plus"} />
      <div className="ant-upload-text">Télécharger image profil</div>
    </div>
  );

  const { imageUrl } = loading;
  //console.log(imageUrl);

  ///////////////////////////////////////////////////////////////////////////////////////////////////////
  const [fileList, setFileList] = useState("");
  const [previewImage, setPreviewImage] = useState("");
  const [previewVisible, setPreviewVisible] = useState(false);
  const [description, setDescription] = useState(
    artisanObject.companyDescription
  );
  const [pictureAvatar, setPictureAvatar] = useState(artisanObject.picture);
  const [pictureGalery, setPictureGalery] = useState(
    artisanObject.pictureFolder
  );

  const getBaseFile = file => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = error => reject(error);
    });
  };

  const handleCancel = () => setPreviewVisible(false);

  const handlePreview = async file => {
    if (!file.url && !file.preview) {
      file.preview = await getBaseFile(file.originFileObj);
    }

    setPreviewVisible(true);
    setPreviewImage(file.url || file.preview);
  };

  const handleChangeFile = fileList => {
    return setFileList(fileList.fileList);
  };

  const uploadButtonFile = (
    <div>
      <Icon type="plus" />
      <div className="ant-upload-text">Ajouter des images</div>
    </div>
  );

  useEffect(() => {
    if (description === undefined) {
      setDescription(artisanObject.companyDescription);
    }

    if (pictureAvatar === undefined) {
      setPictureAvatar(artisanObject.picture);
    }
    if (pictureGalery === undefined) {
      setPictureGalery(artisanObject.pictureFolder);
    }
  });

  //console.log("pictureGalery", pictureGalery);

  const handleSaveClick = () => {
    dispatch(
      artisanEdit(
        artisanObject.email,
        description,
        pictureAvatar,
        pictureGalery
      )
    );
  };

  const handleContentDescription = event => {
    const content = event.target.value;
    setDescription(content);
  };

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
              ) : artisanObject.picture != undefined ? (
                <img
                  //src={`../src/styles/pictures/company/${artisanObject.picture}`}
                  src={`${NAME_SERVER}/${artisanObject.picture}`}
                  alt="avatar"
                  style={{ width: "100%" }}
                />
              ) : (
                uploadButton
              )}
            </Upload>
          </Form.Item>
          <Form.Item label="Nom et Prénom">
            <Input
              placeholder="Nom Prénom"
              value={`${artisanObject.firstname} ${artisanObject.lastname}`}
              disabled={true}
            />{" "}
          </Form.Item>
          <Form.Item label="Siret">
            <Input value={artisanObject.siret} disabled />
          </Form.Item>
          <Form.Item label="Entreprise">
            <Input disabled value={artisanObject.company} />
          </Form.Item>
          <Form.Item label="Adresse">
            <Input
              disabled
              value={`${artisanObject.numberWay} ${artisanObject.way}`}
            />
            <Input disabled value={artisanObject.postalCode} />
            <Input disabled value={artisanObject.city} />
          </Form.Item>
          <Form.Item label="Télephone">
            <Input disabled value={artisanObject.phone} />
          </Form.Item>
          <Form.Item label="Email">
            <Input disabled value={artisanObject.email} />
          </Form.Item>
          <Form.Item label="Description">
            <TextArea onChange={handleContentDescription} rows={4} />
          </Form.Item>
          <div className="clearfix">
            <Form.Item>
              <Upload
                action="https://www.mocky.io/v2/5cc8019d300000980a055e76"
                listType="picture-card"
                onPreview={handlePreview}
                onChange={handleChangeFile}
              >
                {fileList.length >= 4 ? null : uploadButtonFile}
              </Upload>
              <Modal
                visible={previewVisible}
                footer={null}
                onCancel={handleCancel}
              >
                <img
                  alt="example"
                  style={{ width: "100%" }}
                  src={previewImage}
                />
              </Modal>
              <Button
                onClick={handleSaveClick}
                type="primary"
                className="buttons"
                htmlType="submit"
              >
                Sauvegarder
              </Button>
            </Form.Item>
            <Form.Item>
              <Button type="danger" htmlType="submit">
                Supprimer le compte
              </Button>
            </Form.Item>
          </div>
        </Form>
      </Row>
    </div>
  );
};

export default ProfileArtisan;
