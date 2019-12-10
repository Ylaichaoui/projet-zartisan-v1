/**
 * Imports of dependencies
 */
import React, { useState, useEffect } from "react";
import { useSelector } from "react-redux";
import { Row, Button, Icon, Menu, Dropdown, Cascader } from "antd";
import Cookies from "js-cookie";
/**
 * Local imports
 */
import "./style.sass";
import france from "./picture/france.svg";

/**
 * Code
 */

const options = [
  {
    value: "batiment",
    label: "Batiment",
    children: [
      {
        value: "plombier",
        label: "Plombier"
      },
      {
        value: "electricien",
        label: "Electricien"
      }
    ]
  },
  {
    value: "alimentaire",
    label: "Alimentaire",
    children: [
      {
        value: "boulanger",
        label: "Boulanger"
      }
    ]
  }
];

function onChange(value) {
  //console.log(value);
}

const Home = () => {
  /**
   * menu of dropdown region
   */
  const changeRegion = event => {
    setRegion(event.item.props.value);
  };

  const regions = useSelector(state => state.regions);
  //console.log(regions);

  const itemRegions = regions.map(region => {
    return (
      <Menu.Item onClick={changeRegion} key={region.id} value={region.name}>
        {region.name}
      </Menu.Item>
    );
  });
  //console.log(itemRegions);

  const menuRegion = <Menu>{itemRegions}</Menu>;
  /**
   * menu of dropdown jobs
   */

  const [regionChange, setRegion] = useState("Choisissez une Région");

  useEffect(() => {
    Cookies.get("TOKEN");
    //console.log("cest un token " + cookie);
  });

  return (
    <div className="home">
      <Row type="flex" justify="space-around" align="middle">
        <Dropdown overlay={menuRegion} placement="bottomLeft">
          <Button
            className="home-button-region"
            style={{ backgroundColor: "#ad2102", color: "white" }}
          >
            {regionChange} <Icon type="down" />
          </Button>
        </Dropdown>
        <Cascader
          className="home-cascader-jobs"
          options={options}
          onChange={onChange}
          placeholder="Choisissez un métier"
        />
      </Row>
      <Row
        type="flex"
        justify="space-around"
        align="middle"
        className="home-france"
      >
        <img src={france} className="france-picture" />
        <Button
          className="home-button-search"
          style={{ color: "white", backgroundColor: "#595959", border: "none" }}
        >
          Recherche
        </Button>
      </Row>
    </div>
  );
};

export default Home;
