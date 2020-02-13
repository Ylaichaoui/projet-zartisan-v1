import React from "react";
import { Spin } from "antd";
import "./style.sass";

const Loader = () => {
  return (
    <div className="loader">
      <Spin size="large" />
    </div>
  );
};

export default Loader;
