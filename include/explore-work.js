
var explore_functions = [];
var exploreuser;
function execute_explore_functions() {
    // Execute the various explore functions
    for (x in explore_functions) {
	window[explore_functions[x]]();
    }
}

main_functions.push("explore_work_main");
function explore_work_main() {
    // Set variables and fill the variables in prnt classes
    evaluate_and_set_prnt("user");
    evaluate_and_set_prnt("exploreuser");

    execute_explore_functions();
};
