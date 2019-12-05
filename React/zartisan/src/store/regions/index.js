const initialState = [
	{ name: 'Auvergne-Rhône-Alpes', id: '1' },
	{ name: 'Bourgogne-Franche-Comté', id: '2' },
	{ name: 'Bretagne', id: '3' },
	{ name: 'Centre-Val de Loire', id: '4' },
	{ name: 'Corse', id: '5' },
	{ name: 'Grand Est', id: '6' },
	{ name: 'Hauts-de-France', id: '7' },
	{ name: 'Île-de-France', id: '8' },
	{ name: 'Normandie', id: '9' },
	{ name: 'Nouvelle-Aquitaine', id: '10' },
	{ name: 'Occitanie', id: '11' },
	{ name: 'Pays de la Loire', id: '12' },
	{ name: "Provence-Alpes-Côte d'Azur", id: '13' }
];

export default (state = initialState, action) => {
	console.log('reducer >>', action);

	switch (action.type) {
		default: {
			return state;
		}
	}
};
