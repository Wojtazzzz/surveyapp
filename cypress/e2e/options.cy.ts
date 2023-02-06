describe("options tests", () => {
    before(() => {
        cy.artisan("migrate:refresh");
    });

    afterEach(() => {
        cy.artisan("migrate:refresh");
    });
    it("create, edit, and delete option", () => {
        cy.visit("/index");

        cy.assertPageHeading("List of Surveys");

        cy.checkListIsEmpty("Surveys");

        cy.createSurvey("Example Survey");

        cy.assertUrl("survey/questions/1");
        cy.assertPageHeading("List of Questions");

        cy.checkListIsEmpty("Questions");

        // create new question
        cy.get('a[href="/survey/question-create/1"]')
            .contains("New Question")
            .click();

        cy.assertUrl("survey/question-create/1");
        cy.assertPageHeading("Create new Question");

        cy.get('input[id="name"]')
            .should("have.value", "Example Survey")
            .should("be.disabled");
        cy.get('select[name="position"]').should("have.value", 1);
        cy.get('textarea[name="content"]').type("Example content");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/question-options/1/1");
        cy.assertPageHeading("List of Options");

        cy.checkListIsEmpty("Options");

        // create new option
        cy.get('a[href="/survey/question-option-create/1/1"]')
            .contains("New Option")
            .click();

        cy.assertUrl("survey/question-option-create/1/1");
        cy.assertPageHeading("Create new Option");

        cy.get('input[id="name"]')
            .should("have.value", "Example content")
            .should("be.disabled");
        cy.get('input[name="title"]').type("Third option");
        cy.get('input[name="title"]').should("have.value", "Third option");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/question-options/1/1");
        cy.assertPageHeading("List of Options");

        // check first option created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("Third option");

                    cy.get('a[href="/survey/question-option-edit/1/1/1"]')
                        .contains("Edit")
                        .click();
                });
        });

        // edit option
        cy.assertUrl("survey/question-option-edit/1/1/1");
        cy.assertPageHeading("Edit Option");

        cy.get('input[id="name"]')
            .should("have.value", "Example content")
            .should("be.disabled");
        cy.get('input[name="title"]').should("have.value", "Third option");
        cy.get('input[name="title"]').clear().type("First option");
        cy.get('input[name="title"]').should("have.value", "First option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // check option edited
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("First option");
                });
        });

        // add second option
        cy.get('a[href="/survey/question-option-create/1/1"]')
            .contains("New Option")
            .click();

        cy.assertUrl("survey/question-option-create/1/1");
        cy.assertPageHeading("Create new Option");

        cy.get('input[id="name"]')
            .should("have.value", "Example content")
            .should("be.disabled");
        cy.get('input[name="title"]').type("Second option");
        cy.get('input[name="title"]').should("have.value", "Second option");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/question-options/1/1");
        cy.assertPageHeading("List of Options");

        // check second option created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr")
                .last()
                .within(() => {
                    cy.contains("2");
                    cy.contains("Second option");
                });
        });

        // delete first option
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("First option");

                    cy.get('button[type="submit"]').contains("Delete").click();
                });
        });

        // check first option deleted
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr")
                .last()
                .within(() => {
                    cy.contains("2");
                    cy.contains("Second option");
                });
        });
    });
});
