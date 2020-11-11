export default {
	state: {
       user: {}
	},
	getters: {
       getUserData(state){ //take parameter state
          return state.user;
       }
	},
	actions: {
    //    allCategoryFromDatabase(context){
    //       axios.get("api/category")
    //            .then((response)=>{
    //               console.log(response.data.categories)
    //               context.commit("categories",response.data.categories) //categories will be run from mutation
    //            }
    //            .catch(()=>{            
    //               console.log("Error........")        
    //            })
    //    }
	},
	mutations: {
       setUser(state,data) {
          state.user = data;
       }
	}
}