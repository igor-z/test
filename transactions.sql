SELECT
    customer.tin,
    SUM(
        CASE
            WHEN loan_transaction.type = 'loan' THEN loan_transaction.amount
            WHEN loan_transaction.type = 'loan_repayment' THEN -loan_transaction.amount
            WHEN loan_transaction.type = 'interest' THEN loan_transaction.amount
            WHEN loan_transaction.type = 'interest_repayment' THEN -loan_transaction.amount
            ELSE 0
        END
    ) as portfolio,
    ROUND(
        SUM(
            CASE
                WHEN loan_transaction.type = 'loan' THEN loan_transaction.amount
                WHEN loan_transaction.type = 'loan_repayment' THEN -loan_transaction.amount
                WHEN loan_transaction.type = 'interest' THEN loan_transaction.amount
                WHEN loan_transaction.type = 'interest_repayment' THEN -loan_transaction.amount
                ELSE 0
            END
        ) /
        NULLIF(SUM(
            SUM(
                CASE
                    WHEN loan_transaction.type = 'loan' THEN loan_transaction.amount
                    WHEN loan_transaction.type = 'loan_repayment' THEN -loan_transaction.amount
                    WHEN loan_transaction.type = 'interest' THEN loan_transaction.amount
                    WHEN loan_transaction.type = 'interest_repayment' THEN -loan_transaction.amount
                    ELSE 0
                END
            )
        ) OVER (), 0) * 100,
        1
    ) as total_portfolio
FROM tbl_loan_transaction loan_transaction
    JOIN tbl_customer as customer ON customer.id = loan_transaction.customer_id
GROUP BY customer.tin
HAVING
    SUM(
        CASE
            WHEN loan_transaction.type = 'loan' THEN loan_transaction.amount
            WHEN loan_transaction.type = 'loan_repayment' THEN -loan_transaction.amount
            WHEN loan_transaction.type = 'interest' THEN loan_transaction.amount
            WHEN loan_transaction.type = 'interest_repayment' THEN -loan_transaction.amount
            ELSE 0
        END
    ) != 0
ORDER BY portfolio DESC;


