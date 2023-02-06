describe("questions tests", () => {
    before(() => {
        cy.artisan("migrate:refresh");
    });

    afterEach(() => {
        cy.artisan("migrate:refresh");
    });

    it("create, edit, and delete question", () => {
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
        cy.get('textarea[name="content"]').type("E");
        cy.get('textarea[name="content"]').should("have.value", "E");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.checkValidationError(
            "Error! The content must be at least 5 characters."
        );

        cy.get('textarea[name="content"]').clear().type("Example content");
        cy.get('textarea[name="content"]').should(
            "have.value",
            "Example content"
        );
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/question-options/1/1");
        cy.assertPageHeading("List of Options");

        cy.checkListIsEmpty("Options");

        cy.visit("survey/questions/1");

        // check question created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "1");
            cy.get("tbody tr").should("contain.text", "Example content");
            cy.get("tbody tr").should("contain.text", "Single choice");

            cy.get("a").contains("Edit").click();
        });

        // edit question
        cy.assertUrl("survey/question-edit/1/1");
        cy.assertPageHeading("Edit Question");

        cy.get('input[id="name"]')
            .should("have.value", "Example Survey")
            .should("be.disabled");
        cy.get('select[name="position"]').should("have.value", 1);
        cy.get('textarea[name="content"]').should(
            "have.value",
            "Example content"
        );
        cy.get('textarea[name="content"]').clear().type("Ex");
        cy.get('textarea[name="content"]').should("have.value", "Ex");
        cy.get('select[name="type"]').should("have.value", "Single choice");
        cy.get('select[name="type"]').select("Multiple choice");
        cy.get('select[name="type"]').should("have.value", "Multiple choice");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.checkValidationError(
            "Error! The content must be at least 5 characters."
        );

        cy.get('textarea[name="content"]').clear().type("Test content");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/questions/1");
        cy.assertPageHeading("List of Questions");

        // check question edited
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "1");
            cy.get("tbody tr").should("contain.text", "Test content");
            cy.get("tbody tr").should("contain.text", "Multiple choice");

            // delete question
            cy.get('button[type="submit"]').contains("Delete").click();
        });

        cy.checkListIsEmpty("Questions");
    });

    it("questions positions", () => {
        cy.visit("/index");

        cy.assertPageHeading("List of Surveys");

        cy.checkListIsEmpty("Surveys");

        cy.createSurvey("Example Survey");

        cy.assertUrl("survey/questions/1");
        cy.assertPageHeading("List of Questions");

        cy.checkListIsEmpty("Questions");

        // create first question
        cy.get('a[href="/survey/question-create/1"]')
            .contains("New Question")
            .click();

        cy.assertUrl("survey/question-create/1");
        cy.assertPageHeading("Create new Question");

        cy.get('select[name="position"]').should("have.value", 1);
        cy.get('textarea[name="content"]').type("First question");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.visit("survey/questions/1");

        // check first question created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "1");
            cy.get("tbody tr").should("contain.text", "First question");
            cy.get("tbody tr").should("contain.text", "Single choice");
        });

        // create second question
        cy.get('a[href="/survey/question-create/1"]')
            .contains("New Question")
            .click();

        cy.assertUrl("survey/question-create/1");
        cy.assertPageHeading("Create new Question");

        cy.get('select[name="position"]').should("have.value", 2);
        cy.get('textarea[name="content"]').type("Second question");
        cy.get('select[name="type"]').select("Multiple choice");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.visit("survey/questions/1");

        // check second question created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr").should("contain.text", "2");
            cy.get("tbody tr").should("contain.text", "Second question");
            cy.get("tbody tr").should("contain.text", "Multiple choice");

            cy.get('a[href="/survey/question-edit/1/2"]')
                .contains("Edit")
                .click();
        });

        // edit second question
        cy.assertUrl("survey/question-edit/1/2");
        cy.assertPageHeading("Edit Question");

        // change position to first
        cy.get('select[name="position"]').should("have.value", 2);
        cy.get('select[name="position"]').select("1");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("survey/questions/1");
        cy.assertPageHeading("List of Questions");

        // check second question has first position
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("Second question");
                    cy.contains("Multiple choice");
                });
        });

        // check first question has second position
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr")
                .last()
                .within(() => {
                    cy.contains("2");
                    cy.contains("First question");
                    cy.contains("Single choice");
                });
        });

        // delete second question
        // after delete question with first position,
        // second question should have first position
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 2);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("Second question");
                    cy.contains("Multiple choice");

                    cy.get('button[type="submit"]').contains("Delete").click();
                });
        });

        // check first question has first position
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr")
                .first()
                .within(() => {
                    cy.contains("1");
                    cy.contains("First question");
                    cy.contains("Single choice");
                });
        });
    });
});
