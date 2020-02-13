import React, { useState, useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import { Row } from "antd";
import "antd/dist/antd.css";
import FormEditUser from "../../components/FormEditUser";
import Loader from "src/components/Loader";

const ProfileClient = () => {
  const userSelect = useSelector(state => state.user);

  console.log("ussser", userSelect);

  const [profileUser, setProfileUser] = useState({
    pictureAvatar: "",
    nickname: "",
    firstname: "",
    lastname: "",
    phone: "",
    mail: ""
  });

  useEffect(() => {
    setProfileUser({
      pictureAvatar: userSelect.picture,
      nickname: userSelect.nickname,
      firstname: userSelect.firstname,
      lastname: userSelect.lastname,
      phone: userSelect.phone,
      mail: userSelect.mail
    });
  }, [userSelect]);

  //console.log(profileUser);

  return (
    <div>
      <Row type="flex" justify="space-around" align="middle">
        {userSelect == "" ? (
          <Loader />
        ) : (
          <FormEditUser
            profileUser={profileUser}
            setProfileUser={setProfileUser}
          />
        )}
      </Row>
    </div>
  );
};
export default ProfileClient;
