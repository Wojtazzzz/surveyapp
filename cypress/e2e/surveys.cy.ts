describe("surveys tests", () => {
    beforeEach(() => {
        cy.artisan("migrate:refresh");
    });

    it("create, edit, and delete survey", () => {
        cy.visit("/index");

        cy.assertPageHeading("List of Surveys");

        cy.checkListIsEmpty("Surveys");

        // create new survey
        cy.get('a[href="/survey/create"]').contains("New Survey").click();

        cy.assertUrl("survey/create");
        cy.assertPageHeading("Create new Survey");

        cy.get('input[name="name"]').type("X");
        cy.get('input[name="name"]').should("have.value", "X");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.checkValidationError(
            "Error! The name must be at least 5 characters."
        );

        cy.get('input[name="name"]').clear().type("Example Survey");
        cy.get('input[name="name"]').should("have.value", "Example Survey");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.get("h1").contains("Survey App").click();
        cy.assertUrl("index");

        // check survey created
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "Example Survey");
            cy.get("tbody tr").should("contain.text", "Editing");

            cy.get("a").contains("Edit").click();
        });

        // edit survey
        cy.assertUrl("survey/edit/1");

        cy.get('input[name="name"]').should("have.value", "Example Survey");
        cy.get('input[name="name"]').clear().type("T");
        cy.get('input[name="name"]').should("not.have.value", "Example Survey");
        cy.get('input[name="name"]').should("have.value", "T");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.checkValidationError(
            "Error! The name must be at least 5 characters."
        );

        cy.get('input[name="name"]').clear().type("Test Survey");
        cy.get('button[type="submit"]').contains("Submit").click();

        cy.assertUrl("index");

        // check survey edited
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "Test Survey");
            cy.get("tbody tr").should("contain.text", "Editing");

            // delete survey
            cy.get('button[type="submit"]').contains("Delete").click();
        });

        cy.assertUrl("index");

        cy.checkListIsEmpty("Surveys");
    });

    it("cannot complete survey which has edit status", () => {
        cy.visit("/index");

        cy.createSurvey("Example Survey");

        cy.visit("/index");

        cy.get("table").within(() => {
            cy.get('a[href="/survey/show/1"]')
                .contains("Example Survey")
                .click();
        });

        cy.assertUrl("survey/show/1");
        cy.contains("404 Not Found").should("exist");
    });

    it("survey with testing status has additional informations", () => {
        cy.create("Survey", {
            name: "Example Survey",
            status: "Testing",
        });

        cy.create("Question", {
            survey_id: 1,
        });

        cy.create("Option", 2, {
            question_id: 1,
        });

        cy.visit("/index");

        cy.get("table").within(() => {
            cy.get('a[href="/survey/show/1"]')
                .contains("Example Survey")
                .click();
        });

        cy.assertUrl("survey/show/1");

        // check question has specific ID
        cy.get("p").contains("ID 1");

        // check options have specific ID
        cy.get("label ~ span").first().contains("ID 1");
        cy.get("label ~ span").last().contains("ID 2");
    });

    it("create full survey and complete it", () => {
        // create survey with READY status
        cy.create("Survey", {
            name: "Example Survey",
            status: "Ready",
        });

        cy.visit("/index");

        // go to questions page
        cy.get("table").within(() => {
            cy.get("tbody tr").should("have.length", 1);
            cy.get("tbody tr").should("contain.text", "Example Survey");
            cy.get("tbody tr").should("contain.text", "Ready");

            cy.get("a").contains("Link").click();
        });

        // create first question
        cy.get('a[href="/survey/question-create/1"]')
            .contains("New Question")
            .click();

        cy.get('select[name="position"]').should("have.value", 1);
        cy.get('textarea[name="content"]').type("First question");
        cy.get('button[type="submit"]').contains("Submit").click();

        // create first option for first question
        cy.get('a[href="/survey/question-option-create/1/1"]')
            .contains("New Option")
            .click();

        cy.get('input[name="title"]').type("First-1 option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // create second option for first question
        cy.get('a[href="/survey/question-option-create/1/1"]')
            .contains("New Option")
            .click();

        cy.get('input[name="title"]').type("Second-1 option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // create third option for first question
        cy.get('a[href="/survey/question-option-create/1/1"]')
            .contains("New Option")
            .click();

        cy.get('input[name="title"]').type("Third-1 option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // go to list of questions
        cy.visit("/index");

        cy.get("table").within(() => {
            cy.get('a[href="/survey/questions/1"]').contains("Link").click();
        });

        // create second question
        cy.get('a[href="/survey/question-create/1"]')
            .contains("New Question")
            .click();

        cy.get('select[name="position"]').select("2");
        cy.get('textarea[name="content"]').type("Second question");
        cy.get('select[name="type"]').select("Multiple choice");
        cy.get('button[type="submit"]').contains("Submit").click();

        // create first option for second question
        cy.get('a[href="/survey/question-option-create/1/2"]')
            .contains("New Option")
            .click();

        cy.get('input[name="title"]').type("First-2 option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // create second option for second question
        cy.get('a[href="/survey/question-option-create/1/2"]')
            .contains("New Option")
            .click();

        cy.get('input[name="title"]').type("Second-2 option");
        cy.get('button[type="submit"]').contains("Submit").click();

        // go to complete survey page
        cy.visit("/index");

        cy.get("table").within(() => {
            cy.get('a[href="/survey/show/1"]')
                .contains("Example Survey")
                .click();
        });

        cy.assertUrl("survey/show/1");

        // check questions has correct order
        cy.contains("1. First question");
        cy.contains("2. Second question");

        // single choice question have only one correct answer
        cy.get('input[type="radio"][id="1"]').should("be.checked");
        cy.get('input[type="radio"][id="2"]').should("not.be.checked");
        cy.get('input[type="radio"][id="3"]').should("not.be.checked");

        cy.get('label[for="1"]').contains("First-1 option");
        cy.get('label[for="2"]').contains("Second-1 option");
        cy.get('label[for="3"]').contains("Third-1 option");

        // mark second option
        cy.get('label[for="2"]').contains("Second-1 option").click();

        cy.get('input[type="radio"][id="1"]').should("not.be.checked");
        cy.get('input[type="radio"][id="2"]').should("be.checked");
        cy.get('input[type="radio"][id="3"]').should("not.be.checked");

        // mark third option
        cy.get('label[for="3"]').contains("Third-1 option").click();

        cy.get('input[type="radio"][id="1"]').should("not.be.checked");
        cy.get('input[type="radio"][id="2"]').should("not.be.checked");
        cy.get('input[type="radio"][id="3"]').should("be.checked");

        // multiple choice question have multiple correct answers
        cy.get('input[type="checkbox"][id="4"]').should("be.checked");
        cy.get('input[type="checkbox"][id="5"]').should("not.be.checked");

        cy.get('label[for="4"]').contains("First-2 option");
        cy.get('label[for="5"]').contains("Second-2 option");

        // mark second option
        cy.get('label[for="5"]').contains("Second-2 option").click();

        cy.get('input[type="checkbox"][id="4"]').should("be.checked");
        cy.get('input[type="checkbox"][id="5"]').should("be.checked");

        // unmark first option
        cy.get('label[for="4"]').contains("First-2 option").click();

        cy.get('input[type="checkbox"][id="4"]').should("not.be.checked");
        cy.get('input[type="checkbox"][id="5"]').should("be.checked");
    });
});
