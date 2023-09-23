<?php
date_default_timezone_set('Russia/Moscow');

// Function to add a text note to the card
function addNoteToCard($action, $details)
{

}

// Receive the webhook from amoCRM
$receivedData = file_get_contents('php://input');
$webhook = json_decode($receivedData, true);

if ($webhook) {
    // Check the event type in the webhook
    $eventType = $webhook['event'];

    // Action based on the event type
    switch ($eventType) {
        case 'add_lead':
            $action = 'Card created';
            $details = "Business/Contact name: " . $webhook['leads']['name'] . "\nResponsible: " . $webhook['leads']['responsible_user_name'];
            addNoteToCard($action, $details);
            break;

        case 'update_lead':
            $action = 'Card updated';
            $details = "Names and new values of changed fields: \n";
            foreach ($webhook['leads']['status'] as $field => $newValue) {
                $details .= "$field: $newValue\n";
            }
            addNoteToCard($action, $details);
            break;

        // Add more cases for other event types if needed

        default:
            // Handle other event types, if applicable
            break;
    }
}
?>