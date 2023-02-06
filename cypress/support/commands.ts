Cypress.Commands.add("assertUrl", (path: string) => {
    cy.url().should("eq", Cypress.config().baseUrl + path);
});

Cypress.Commands.add("assertPageHeading", (text: string) => {
    cy.get("h2").should("have.text", text).should("exist");
});

Cypress.Commands.add("checkValidationError", (error: string) => {
    cy.get("ul li").contains(error);
});

const emptyListMessages = {
    Surveys:
        "There are no Surveys in the App. You can create new one by click on button above",
    Questions:
        "There are no Questions within this Survey. You can create new one by click on button above",
    Options:
        "There are no Options within this Question. You can create new one by click on button above",
} as const;

Cypress.Commands.add(
    "checkListIsEmpty",
    (model: "Surveys" | "Questions" | "Options") => {
        cy.get("main").contains(emptyListMessages[model]);
    }
);

Cypress.Commands.add("createSurvey", (name: string) => {
    cy.get('a[href="/survey/create"]').contains("New Survey").click();

    cy.assertUrl("survey/create");
    cy.assertPageHeading("Create new Survey");

    cy.get('input[name="name"]').type(name);
    cy.get('input[name="name"]').should("have.value", name);
    cy.get('button[type="submit"]').contains("Submit").click();
});
