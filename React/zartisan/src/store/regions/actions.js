export const GET_REGIONS = "regions/actions/GET_REGIONS";

<<<<<<< HEAD
export const getRegions = (regions = {}) => ({
  type: GET_REGIONS,
  regions
});

export const REGIONS = "regions/actions/REGIONS";

export const regions = regions => ({
  type: REGIONS,
  regions
=======
export const getRegions = cookie => ({
  type: GET_REGIONS,
  cookie
>>>>>>> 053223ab25d91cb3e3a41cbf2a4809de14b16359
});
