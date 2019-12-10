export const GET_REGIONS = "regions/actions/GET_REGIONS";

export const getRegions = (regions = {}) => ({
  type: GET_REGIONS,
  regions
});

export const REGIONS = "regions/actions/REGIONS";

export const regions = regions => ({
  type: REGIONS,
  regions
});
