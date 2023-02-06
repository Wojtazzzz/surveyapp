import "./commands";

import { useCypressLaravel } from "cypress-laravel";

useCypressLaravel();

declare global {
    namespace Cypress {
        interface Chainable {
            assertUrl(path: string): Chainable<JQuery<HTMLElement>>;
            assertPageHeading(text: string): Chainable<JQuery<HTMLElement>>;
            checkValidationError(error: string): Chainable<JQuery<HTMLElement>>;
            checkListIsEmpty(
                model: "Surveys" | "Questions" | "Options"
            ): Chainable<JQuery<HTMLElement>>;
            createSurvey(name: string): Chainable<JQuery<HTMLElement>>;
        }
    }
}
