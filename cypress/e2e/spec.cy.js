describe('User Registration', () => {
  beforeEach(() => {
    cy.visit('http://localhost:3000/register');
  });

  it('allows a user to register successfully', () => {
    cy.get('input[placeholder="Full Name"]').type('Test User');
    cy.get('input[placeholder="Email Address"]').type('testuser@example.com');
    cy.get('input[placeholder="Password"]').type('TestUser123!');
    cy.get('input[placeholder="Repeat Password"]').type('TestUser123!');

    cy.get('button').contains('Register').click();

    cy.url().should('include', '/user');

    cy.contains('Welcome').should('exist');
  });

  it('shows validation errors if fields are empty', () => {
    cy.get('button').contains('Register').click();

    cy.contains('The name field is required').should('exist');
    cy.contains('The email field is required').should('exist');
    cy.contains('The password field is required').should('exist');
  });
});
