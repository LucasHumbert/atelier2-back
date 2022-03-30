<?php

/**
 * @api {get} /auth Connexion
 * @apiName Auth
 * @apiGroup Auth
 * @apiSuccess {String} accessToken  Token JWT généré qui sera stocker dans le locale storage de l'utilisateur
 * @apiSuccess {String} refreshToken  Token de rafraichissement du JWT.
 * @apiSuccess {String} user_id  ID unique de l'utilisateur
 *
 * @apiSuccessExample Success-Response:
 *{
 *  "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOi8vYXBpLmF1dGgubG9jYWwvYXV0aCIsImF1ZCI6Imh0dHA6Ly9hcGkuYXV0aC5sb2NhbCIsImlhdCI6MTY0ODY0NTM5MSwiZXhwIjoxNjc5NzQ5MzkxLCJ1cHIiOnsiaWQiOiJiNjNlZWExYy1kYjRjLTQwNjEtODYxZi1iMzQwYjAxZDNiZmMiLCJlbWFpbCI6ImJhcHRpc3RlQGdtYWlsLmNvbSIsImZpcnN0bmFtZSI6IkhvdXF1ZXMgIiwibGFzdG5hbWUiOiJCYXB0aXN0ZSIsImxldmVsIjowfX0.i0TuOKQkNBzXlI36u6dqQfNz2fvtyxeuoGZ0g9XGcE9TrY0UuDDW3Lyi9wh4iS3T3AwPGuyP2KFfHjJC-WthrA",
 *    "refreshToken": "364250c04e8048d0fb048497738694342ce1763ad8782baa14dd3d3f22ecb7b9",
 *    "user_id": "b63eea1c-db4c-4061-861f-b340b01d3bfc"
 *}
 *
 *
 * @apiErrorExample Error-Response:
 *[
 *   "Erreur authentification"
 *]
 */

/**
 * @api {post} /register Inscription
 * @apiName Register
 * @apiGroup Auth
 * 
 * @apiBody {String} mail Adresse email de l'utilisateur
 * @apiBody {String} firstname Prénom de l'utilisateur
 * @apiBody {String} lastname Nom de famille de l'utilisateur
 * @apiBody {String} password Mot de passe de l'utilisateur
 * @apiBody {String} confirmpassword Confirmation du mot de passe utilisateur
 * 
 * @apiSuccess {Object} user  Renvoie un object avec les informations de l'utilisateur qui vient de s'inscrire
 * @apiSuccess {String} user.firstname  Prénom de l'utilisateur
 * @apiSuccess {String} user.lastname  Nom de l'utilisateur
 * @apiSuccess {Object} user.mail  Mail de l'utilisateur
 * 
 * @apiSuccessExample Success-Response:
 *  {
 *   "user": {
 *       "firstname": "test",
 *       "lastname": "test2",
 *       "mail": "test@gmail.com"
 *   }
 *}
 *
 *
 * @apiErrorExample Error-Response:
 *{
 *   "error": "Incorrect password"
 *}
 */

 /**
 * @api {post} /me Vérification du token
 * @apiName VerifToken
 * @apiGroup Auth
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * @apiSuccess {Object} profile  Renvoie un object avec les informations de l'utilisateur qui vient de s'inscrire
 * @apiSuccess {Object} profile.email  Email de l'utilisateur du token
 * @apiSuccess {Object} profile.firstname Prénom de l'utilisateur du token
 * @apiSuccess {Object} profile.lastname  Nom de l'utilisateur du token
 * @apiSuccess {Object} profile.level  Niveau d'accès de l'utilisateur
 * @apiSuccessExample Success-Response:
    {
        "profile": {
            "email": "baptiste@test.com",
            "firstname": "Baptiste",
            "lastname": "Houques",
            "level": 10
        }
    }
 *
 *
 * @apiErrorExample Error-Response:
 *{
 *   "error": "Incorrect password"
 *}
 */

  /**
 * @api {delete} /events/:id Suppression d'événement
 * @apiVersion 1.0.0
 * @apiName deleteEvent
 * @apiGroup Events
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * @apiParam {String} id Unique ID de l'événement à supprimer
 * 
 * @apiSuccess {String} message Message de succès
 * @apiSuccessExample Success-Response:
    {
        'message' : 'deleted'
    }
 *
 *
 */

/**
 * @api {get} /events/:id/messages Récupération des messages liés à un évent
 * @apiName messageEvent
 * @apiGroup Events
 * @apiParam {String} id Unique ID de l'événement à supprimer
 * 
 * @apiSuccess {String} type Type de retour
 * @apiSuccess {Object[]} messages Tableau des messages
 * @apiSuccess {String} messages.user_id UUID de l'utilisateur
 * @apiSuccess {String} messages.event_id UUID de l'événement
 * @apiSuccess {String} messages.content Contenu du message
 * @apiSuccess {String} messages.date Date d'envoie du message
 * @apiSuccess {Object} messages.user Utilisateur qui envoie le message
 * @apiSuccess {String} messages.user.firstname Prénom de l'utilisateur
 * @apiSuccess {Object} messages.user.lastname Nom de l'utilisateur
 * @apiSuccess {Object} messages.links Lien utile
 * @apiSuccess {Object} messages.links.self Lien utile relatif à l'événement
 * @apiSuccess {String} messages.links.href Lien pour vers la ressource
 * 
 * @apiSuccessExample Success-Response:
    {
        "type": "ressource",
        "messages": [
            {
                "user_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
                "event_id": "047aaedc-6519-42f0-af04-892c2fe49b21",
                "content": "https://www.youtube.com/watch?v=l04BpnlteSY&ab_channel=LeRieur",
                "date": "2022-03-28 14:07:43",
                "user": {
                    "firstname": "Budzik",
                    "lastname": "Valentin"
                }
            },
            {
                "user_id": "b63eea1c-db4c-4061-861f-b340b01d3bfc",
                "event_id": "047aaedc-6519-42f0-af04-892c2fe49b21",
                "content": "Je viens !",
                "date": "2022-03-30 08:51:34",
                "user": {
                    "firstname": "Houques ",
                    "lastname": "Baptiste"
                }
            }
        ],
        "links": {
            "self": {
                "href": "http://api.event.local:62560/events/047aaedc-6519-42f0-af04-892c2fe49b21/messages"
            }
        }
    }
 *
 * @apiErrorExample Error-Response:
{
    "type": "ressource",
    "messages": [],
    "links": {
        "self": {
            "href": "http://api.event.local:62560/events/047aaedc-6519-42f0-af04-892c2e49b21/messages"
        }
    }
}
 *
 */

/**
 * @api {post} /events/:eventId/message Envoie d'un message sur un événement
 * @apiName sendMessage
 * @apiGroup Events
 * @apiParam {String} eventId Unique ID de l'événement où poster le message
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * @apiBody {String} content Contenu du message
 * 
 * @apiSuccess {Object} message Contenue du message
 * @apiSuccess {String} message.event_id Id de l'événement ou le message est posté
 * @apiSuccess {String} message.user_id Id de l'utilisateur qui envoie le message
 * @apiSuccess {String} message.content Contenue du message
 * @apiSuccess {String} date Date de l'envoie du message
 * 
 * @apiSuccessExample Success-Response:
 {
    "message": {
        "event_id": "047aaedc-6519-42f0-af04-892c2fe49b21",
        "user_id": "b63eea1c-db4c-4061-861f-b340b01d3bfc",
        "content": "c'est un texte",
        "date": "2022-03-30 15:17:35"
    }
}
 *
 * @apiErrorExample Error-Response:
{
    "error": "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'content' cannot be null (SQL: insert into message (content, date, event_id, user_id) values (?, 22-03-30 15:18:14, 047aaedc-6519-42f0-af04-892c2fe49b21, b63eea1c-db4c-4061-861f-b340b01d3bfc))"
}
 *
 */

/**
 * @api {post} /events/:eventId/invitation Envoie une invitation à un utilisateur
 * @apiName sendInvite
 * @apiGroup Events
 * @apiParam {String} eventId Unique ID de l'événement où poster le message
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * @apiBody {String} content Contenu du message
 * 
 * @apiSuccess {Object} message Contenue du message
 * @apiSuccess {String} message.event_id Id de l'événement ou le message est posté
 * @apiSuccess {String} message.user_id Id de l'utilisateur qui envoie le message
 * @apiSuccess {String} message.content Contenue du message
 * @apiSuccess {String} date Date de l'envoie du message
 * 
 * @apiSuccessExample Success-Response:
 {
    "message": {
        "event_id": "047aaedc-6519-42f0-af04-892c2fe49b21",
        "user_id": "b63eea1c-db4c-4061-861f-b340b01d3bfc",
        "content": "c'est un texte",
        "date": "2022-03-30 15:17:35"
    }
}
 *
 * @apiErrorExample Error-Response:
{
    "error": "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'content' cannot be null (SQL: insert into message (content, date, event_id, user_id) values (?, 22-03-30 15:18:14, 047aaedc-6519-42f0-af04-892c2fe49b21, b63eea1c-db4c-4061-861f-b340b01d3bfc))"
}
 *
 */

 /**
 * @api {get} /users/:id Récupérer un utilisateur
 * @apiName getUser
 * @apiGroup Users
 * @apiParam {String} id Unique ID de l'événement où poster le message
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * 
 * @apiSuccess {Object} user Utilisateur
 * @apiSuccess {String} user.firstname Prénom de l'utilisateur
 * @apiSuccess {String} user.lastname Nom de l'utilisateur
 * @apiSuccess {Object[]} messages Liste des messages envoyé par l'utilisateur
 * 
 * @apiSuccessExample Success-Response:
{
    "user": {
        "firstname": "Houques ",
        "lastname": "Baptiste",
        "messages": []
    }
}
 *
 * @apiErrorExample Error-Response:

{
    "error": "Unauthorized"
}
 *
 */

  /**
 * @api {get} /users/:id/events Recupérer les events d'un utilisateur
 * @apiName getEventUser
 * @apiGroup Users
 * @apiParam {String} id Unique ID de l'événement où poster le message
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * 
 * @apiSuccess {Array[Object]} events Utilisateur
 * @apiSuccess {String} event.id Id de l'événement
 * @apiSuccess {String} event.creator_id Id du créateur
 * @apiSuccess {String} event.title Titre de l'événement
 * @apiSuccess {String} event.description Description de l'événement
 * @apiSuccess {String} event.data Date de l'événement
 * @apiSuccess {String} event.address Adresse de l'événement
 * @apiSuccess {int} event.lat Latitude géographique de l'événement
 * @apiSuccess {int} event.lon Longitude géographique de l'événement
 * @apiSuccess {int} event.public Disponibilitée de l'événement
 * @apiSuccess {String} event.created_at Date de création de l'événement
 * @apiSuccess {String} event.updated_at Date de la dernière update de l'événement
 * @apiSuccess {int} event.choice Choix de l'utilisateur par rapport à l'événement ( présent / pas présent )
 * 
 * @apiSuccessExample Success-Response:
{
    "events": [
        {
            "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
            "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
            "title": "Anniversaire de Valentin",
            "description": "C'est mon anniversaire",
            "date": "2024-06-06 16:00:36",
            "address": "Bischwiller 25 Rue Des Cimetières",
            "lat": 48.7721,
            "lon": 7.85158,
            "public": 1,
            "created_at": "2022-03-28T14:01:28.000000Z",
            "updated_at": "2022-03-28T14:01:28.000000Z",
            "choice": 1
        }
    ]
}
 *
 * @apiErrorExample Error-Response:

{
    "error": "Unauthorized"
}
 *
 */

/**
 * @api {put} /users/:id Mise a jour des données utilisateurs
 * @apiName putUser
 * @apiGroup Users
 * @apiParam {String} id Unique ID de l'événement où poster le message
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * 
 * @apiSuccess {String} message Confirmation d'update
 * 
 * @apiSuccessExample Success-Response:
{
    "message": "User updated"
}
 *
 * @apiErrorExample Error-Response:
{
    "message": "Syntax error, malformed JSON"
}
 *

 /**
 * @api {post} /events Poste d'un événement
 * @apiName postEvent
 * @apiGroup Events
 * 
 * @apiHeader (Authorisation) {String} accessToken Le token JWT de l'utilisateur
 * 
 * @apiBody {String} title Titre de l'événement
 * @apiBody {String} description Description de l'évéenement
 * @apiBody {String} date Date de l'événement
 * @apiBody {String} adresse Adresse de l'événement
 * @apiBody {int} lat Latitude géographique de l'événement
 * @apiBody {int} lon Longitude géographique de l'événement
 * @apiBody {int} public Disponibilitée de l'événement
 * 
 * @apiSuccess {String} event Objet correspondant à l'événement crée
 * @apiSuccess {String} event.id Id de l'événement
 * @apiSuccess {String} event.creator_id Id du créateur de l'événement
 * @apiSuccess {String} event.title Titre de l'événement
 * @apiSuccess {String} event.description Description de l'événement
 * @apiSuccess {String} event.data Date de l'événement
 * @apiSuccess {String} event.address Adresse de l'événement
 * @apiSuccess {int} event.lat Latitude géographique de l'événement
 * @apiSuccess {int} event.lon Longitude géographique de l'événement
 * @apiSuccess {String} event.public Disponibilitée de l'événement
 * @apiSuccess {String} event.updated_at Date de la dernière éditions
 * @apiSuccess {String} event.created_at Date de la création de l'événement ( maintenant )
 * 
 * @apiSuccessExample Success-Response:
{
    "event": {
        "id": "f67e5572-6e07-4d88-9a8e-98a4a2b433d4",
        "creator_id": "b63eea1c-db4c-4061-861f-b340b01d3bfc",
        "title": "Anniversaire du z",
        "description": "c'est mon anniv! Venez nombreux",
        "date": "23-01-14 00:00:00",
        "address": "14 rue des champignons",
        "lat": 1.235,
        "lon": 4.236,
        "public": 1,
        "updated_at": "2022-03-30T15:58:19.000000Z",
        "created_at": "2022-03-30T15:58:19.000000Z"
    }
}
 *
 * @apiErrorExample Error-Response:
{
    "message": "Attribut nom non existant"
}
 *

 





 <?php
/**
 *
 * @api {get} /homeInfos Récupérer les infos de la home page
 * @apiName GetHomeInfos
 * @apiGroup BackOffice
 *
 * @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {int} nbUsers  Nombre d'utilisateur dans la base de données.
 * @apiSuccess {int} nbEvents   Nombre d'utilisateur dans la base de données.
 * @apiSuccess {int} nbMessages  Nombre de messages dans la base de données.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "nbUsers": 28,
 *       "nbEvents": 12,
 *       "nbMessages": 38
 *     }
 *
 */

/**
 *
 * @api {get} /events Récupérer tous les événements
 * @apiName GetEvents
 * @apiGroup BackOffice
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} inactive  0 = événement actif,  1 = événement inactif.
 * @apiSuccess {Array} creatorUser  Créateur de l'événement.
 * @apiSuccess {String} creatorUser.firstname  Prénom du créateur de l'événement.
 * @apiSuccess {String} creatorUser.lastname  Nom de famille du créateur de l'événement.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "events": [
 *               {
 *                   "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *                   "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *                   "title": "Anniversaire de Valentin",
 *                   "description": "C'est mon anniversaire",
 *                   "date": "2024-06-06 16:00:36",
 *                   "address": "Bischwiller 25 Rue Des Cimetières",
 *                   "lat": 48.7721,
 *                   "lon": 7.85158,
 *                   "public": 1,
 *                   "created_at": "2022-03-28 14:01:28",
 *                   "updated_at": "2022-03-28 14:01:28",
 *                   "inactive": 0,
 *                   "creatorUser": {
 *                          "firstname": "Valentin",
 *                          "lastname": "Budzik"
 *                   }
 *               }
 *          ]
 *     }
 *
 */

/**
 *
 * @api {get} /events/:id Récupérer un événement
 * @apiName GetEvent
 * @apiGroup BackOffice
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 * @apiQuery {Array} embed Intégrer les messages et/ou les participants de l'événement
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *          "event": {
 *              "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *              "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *              "title": "Anniversaire de Valentin",
 *              "description": "C'est mon anniversaire",
 *              "date": "2024-06-06 16:00:36",
 *              "address": "Bischwiller 25 Rue Des Cimetières",
 *              "lat": 48.7721,
 *              "lon": 7.85158,
 *              "public": 1,
 *              "created_at": "2022-03-28 14:01:28",
 *              "updated_at": "2022-03-28 14:01:28"
 *           }
 *      }
 *
 */

/**
 *
 * @api {DELETE} /events/:id Supprimer un événement
 * @apiName DeleteEvent
 * @apiGroup BackOffice
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 *
 * @apiSuccess {String} response  Message de réponse.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "response": "Event deleted"
 *     }
 *
 */

/**
 *
 * @api {get} /events/:id Récupérer un événement
 * @apiName GetEvent
 * @apiGroup BackOffice
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 * @apiQuery {Array} embed Intégrer les messages et/ou les participants de l'événement
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *          "event": {
 *              "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *              "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *              "title": "Anniversaire de Valentin",
 *              "description": "C'est mon anniversaire",
 *              "date": "2024-06-06 16:00:36",
 *              "address": "Bischwiller 25 Rue Des Cimetières",
 *              "lat": 48.7721,
 *              "lon": 7.85158,
 *              "public": 1,
 *              "created_at": "2022-03-28 14:01:28",
 *              "updated_at": "2022-03-28 14:01:28"
 *          }
 *      }
 *
 */

/**
 *
 * @api {get} /users Récupérer tous les utilisateurs
 * @apiName GetUsers
 * @apiGroup BackOffice
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {String} id  Identifiant de l'utilisateur.
 * @apiSuccess {String} firstname   Prénom de l'utilisateur.
 * @apiSuccess {String} lastname   Nom de l'utilisateur.
 * @apiSuccess {String} mail   Email de l'utilisateur.
 * @apiSuccess {String} password   Mot de passe de l'utilisateur.
 * @apiSuccess {int} level  Niveau d'administration de l'utilisateur.
 * @apiSuccess {String} refresh_token  Refresh token.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} inactive  0 = utilisateur actif, 1 = utilisateur inactif.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *           "users": [
 *              {
 *                  "id": "4c9529e0-1fd0-485f-b69f-37c71e909042",
 *                  "firstname": "Lucas",
 *                  "lastname": "Humbert",
 *                  "mail": "lucas@gmail.com",
 *                  "password": "$2y$10$Zjtnl7LRo8xgVACsy4KlXOBkeIEfTuwTJjp9CQymBxJ0Pbe7cuQhG",
 *                  "level": 10,
 *                  "refresh_token": "58c2393fb1600bb70b416c795e50d1c1a4f9c10abaa05941e3de50264923b442",
 *                  "created_at": "2022-03-28 13:02:51",
 *                  "updated_at": "2022-03-30 14:37:52",
 *                  "inactive": 0
 *              },
 *           ]
 *      }
 *
 */

/**
 *
 * @api {get} /users/:id Récupérer un utilisateur et tous ses événements
 * @apiName GetUser
 * @apiGroup BackOffice
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *  @apiParam  {String} id Identifiant de l'utilisateur
 *
 * @apiSuccess {Array} user  Utilisateur.
 * @apiSuccess {String} user.id  Identifiant de l'utilisateur.
 * @apiSuccess {String} user.firstname   Prénom de l'utilisateur.
 * @apiSuccess {String} user.lastname   Nom de l'utilisateur.
 * @apiSuccess {String} user.mail   Email de l'utilisateur.
 * @apiSuccess {String} user.password   Mot de passe de l'utilisateur.
 * @apiSuccess {int} user.level  Niveau d'administration de l'utilisateur.
 * @apiSuccess {String} user.refresh_token  Refresh token.
 * @apiSuccess {Date} user.created_at  Date de création dans la base.
 * @apiSuccess {Date} user.updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} user.inactive  0 = utilisateur actif, 1 = utilisateur inactif.
 *
 * @apiSuccess {Array} events  Evénements de l'utilisateur.
 * @apiSuccess {String} events.id  Identifiant de l'événement.
 * @apiSuccess {String} events.creator_id   Identifiant du créateur.
 * @apiSuccess {String} events.title  Titre de l'événement.
 * @apiSuccess {String} events.description  Description de l'événement.
 * @apiSuccess {Date} events.date  Date de l'événement.
 * @apiSuccess {String} events.address  Addresse de l'événement.
 * @apiSuccess {int} events.lat  Latitude de l'événement.
 * @apiSuccess {int} events.lon  Longitude de l'événement.
 * @apiSuccess {Bool} events.public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} events.created_at  Date de création dans la base.
 * @apiSuccess {Date} events.updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} events.inactive  0 = événement actif, 1 = événement inactif.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *           "user": {
 *               "id": "56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7",
 *               "firstname": "Calvin",
 *               "lastname": "Lambert",
 *               "mail": "calvin@gmail.com",
 *               "password": "$2y$10$qQpA4eEfAPCtnZggTJmzney7iU3sSPjsuXic3SjanGUjSZBuXKx4q",
 *               "level": 0,
 *               "refresh_token": "de7b86c5007cb0d7aa63f6db011858f46d7b3e25f793a3db80688f538bb9982e",
 *               "created_at": "2022-03-28 13:38:12",
 *               "updated_at": "2022-03-29 06:55:22",
 *               "inactive": 0
 *           },
 *           "events": [
 *               {
 *                   "id": "1b2a06ba-45ae-4f42-a1c5-67da4490cfd6",
 *                   "creator_id": "56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7",
 *                   "title": "Fête de Calvin",
 *                   "description": "C'est une fête organisé par Calvin",
 *                   "date": "2022-03-08 10:45:00",
 *                   "address": "Nancy 8 Rue De La Faïencerie",
 *                   "lat": 48.69,
 *                   "lon": 6.18372,
 *                   "public": 1,
 *                   "created_at": "2022-03-28 13:40:43",
 *                   "updated_at": "2022-03-28 13:40:43",
 *                   "inactive": 0,
 *               }
 *          ]
 *      }
 *
 */

/**
 *
 * @api {DELETE} /users/:id Supprimer un utilisateur
 * @apiName DeleteUser
 * @apiGroup BackOffice
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'utilisateur
 *
 *
 * @apiSuccess {String} response  Message de réponse.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "response": "User deleted"
 *     }
 *
 */


<?php
/**
 *
 * @api {get} /homeInfos Récupérer les infos de la home page
 * @apiName GetHomeInfos
 * @apiGroup Home
 *
 * @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {int} nbUsers  Nombre d'utilisateur dans la base de données.
 * @apiSuccess {int} nbEvents   Nombre d'utilisateur dans la base de données.
 * @apiSuccess {int} nbMessages  Nombre de messages dans la base de données.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "nbUsers": 28,
 *       "nbEvents": 12,
 *       "nbMessages": 38
 *     }
 *
 */

/**
 *
 * @api {get} /events Récupérer tous les événements
 * @apiName GetEvents
 * @apiGroup Events
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} inactive  0 = événement actif,  1 = événement inactif.
 * @apiSuccess {Array} creatorUser  Créateur de l'événement.
 * @apiSuccess {String} creatorUser.firstname  Prénom du créateur de l'événement.
 * @apiSuccess {String} creatorUser.lastname  Nom de famille du créateur de l'événement.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "events": [
 *               {
 *                   "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *                   "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *                   "title": "Anniversaire de Valentin",
 *                   "description": "C'est mon anniversaire",
 *                   "date": "2024-06-06 16:00:36",
 *                   "address": "Bischwiller 25 Rue Des Cimetières",
 *                   "lat": 48.7721,
 *                   "lon": 7.85158,
 *                   "public": 1,
 *                   "created_at": "2022-03-28 14:01:28",
 *                   "updated_at": "2022-03-28 14:01:28",
 *                   "inactive": 0,
 *                   "creatorUser": {
 *                          "firstname": "Valentin",
 *                          "lastname": "Budzik"
 *                   }
 *               }
 *          ]
 *     }
 *
 */

/**
 *
 * @api {get} /events/:id Récupérer un événement
 * @apiName GetEvent
 * @apiGroup Events
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 * @apiQuery {Array} embed Intégrer les messages et/ou les participants de l'événement
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *          "event": {
 *              "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *              "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *              "title": "Anniversaire de Valentin",
 *              "description": "C'est mon anniversaire",
 *              "date": "2024-06-06 16:00:36",
 *              "address": "Bischwiller 25 Rue Des Cimetières",
 *              "lat": 48.7721,
 *              "lon": 7.85158,
 *              "public": 1,
 *              "created_at": "2022-03-28 14:01:28",
 *              "updated_at": "2022-03-28 14:01:28"
 *           }
 *      }
 *
 */

/**
 *
 * @api {DELETE} /events/:id Supprimer un événement
 * @apiName DeleteEvent
 * @apiGroup Events
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 *
 * @apiSuccess {String} response  Message de réponse.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "response": "Event deleted"
 *     }
 *
 */

/**
 *
 * @api {get} /events/:id Récupérer un événement
 * @apiName GetEvent
 * @apiGroup Events
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'événement
 *
 * @apiQuery {Array} embed Intégrer les messages et/ou les participants de l'événement
 *
 * @apiSuccess {String} id  Identifiant de l'événement.
 * @apiSuccess {String} creator_id   Identifiant du créateur.
 * @apiSuccess {String} title  Titre de l'événement.
 * @apiSuccess {String} description  Description de l'événement.
 * @apiSuccess {Date} date  Date de l'événement.
 * @apiSuccess {String} address  Addresse de l'événement.
 * @apiSuccess {int} lat  Latitude de l'événement.
 * @apiSuccess {int} lon  Longitude de l'événement.
 * @apiSuccess {Bool} public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *          "event": {
 *              "id": "047aaedc-6519-42f0-af04-892c2fe49b21",
 *              "creator_id": "4f5cf2a0-c9ce-4acf-a5e5-ec7c5bb96c66",
 *              "title": "Anniversaire de Valentin",
 *              "description": "C'est mon anniversaire",
 *              "date": "2024-06-06 16:00:36",
 *              "address": "Bischwiller 25 Rue Des Cimetières",
 *              "lat": 48.7721,
 *              "lon": 7.85158,
 *              "public": 1,
 *              "created_at": "2022-03-28 14:01:28",
 *              "updated_at": "2022-03-28 14:01:28"
 *          }
 *      }
 *
 */

/**
 *
 * @api {get} /users Récupérer tous les utilisateurs
 * @apiName GetUsers
 * @apiGroup Users
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *
 * @apiSuccess {String} id  Identifiant de l'utilisateur.
 * @apiSuccess {String} firstname   Prénom de l'utilisateur.
 * @apiSuccess {String} lastname   Nom de l'utilisateur.
 * @apiSuccess {String} mail   Email de l'utilisateur.
 * @apiSuccess {String} password   Mot de passe de l'utilisateur.
 * @apiSuccess {int} level  Niveau d'administration de l'utilisateur.
 * @apiSuccess {String} refresh_token  Refresh token.
 * @apiSuccess {Date} created_at  Date de création dans la base.
 * @apiSuccess {Date} updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} inactive  0 = utilisateur actif, 1 = utilisateur inactif.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *           "users": [
 *              {
 *                  "id": "4c9529e0-1fd0-485f-b69f-37c71e909042",
 *                  "firstname": "Lucas",
 *                  "lastname": "Humbert",
 *                  "mail": "lucas@gmail.com",
 *                  "password": "$2y$10$Zjtnl7LRo8xgVACsy4KlXOBkeIEfTuwTJjp9CQymBxJ0Pbe7cuQhG",
 *                  "level": 10,
 *                  "refresh_token": "58c2393fb1600bb70b416c795e50d1c1a4f9c10abaa05941e3de50264923b442",
 *                  "created_at": "2022-03-28 13:02:51",
 *                  "updated_at": "2022-03-30 14:37:52",
 *                  "inactive": 0
 *              },
 *           ]
 *      }
 *
 */

/**
 *
 * @api {get} /users/:id Récupérer un utilisateur et tous ses événements
 * @apiName GetUser
 * @apiGroup Users
 *
 *  @apiParam  {String} token Token de l'utilisateur
 *  @apiParam  {String} id Identifiant de l'utilisateur
 *
 * @apiSuccess {Array} user  Utilisateur.
 * @apiSuccess {String} user.id  Identifiant de l'utilisateur.
 * @apiSuccess {String} user.firstname   Prénom de l'utilisateur.
 * @apiSuccess {String} user.lastname   Nom de l'utilisateur.
 * @apiSuccess {String} user.mail   Email de l'utilisateur.
 * @apiSuccess {String} user.password   Mot de passe de l'utilisateur.
 * @apiSuccess {int} user.level  Niveau d'administration de l'utilisateur.
 * @apiSuccess {String} user.refresh_token  Refresh token.
 * @apiSuccess {Date} user.created_at  Date de création dans la base.
 * @apiSuccess {Date} user.updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} user.inactive  0 = utilisateur actif, 1 = utilisateur inactif.
 *
 * @apiSuccess {Array} events  Evénements de l'utilisateur.
 * @apiSuccess {String} events.id  Identifiant de l'événement.
 * @apiSuccess {String} events.creator_id   Identifiant du créateur.
 * @apiSuccess {String} events.title  Titre de l'événement.
 * @apiSuccess {String} events.description  Description de l'événement.
 * @apiSuccess {Date} events.date  Date de l'événement.
 * @apiSuccess {String} events.address  Addresse de l'événement.
 * @apiSuccess {int} events.lat  Latitude de l'événement.
 * @apiSuccess {int} events.lon  Longitude de l'événement.
 * @apiSuccess {Bool} events.public  0 = l'événement est privé,  1 = l'événement est public.
 * @apiSuccess {Date} events.created_at  Date de création dans la base.
 * @apiSuccess {Date} events.updated_at  Date de modification dans la base.
 * @apiSuccess {Bool} events.inactive  0 = événement actif, 1 = événement inactif.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *           "user": {
 *               "id": "56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7",
 *               "firstname": "Calvin",
 *               "lastname": "Lambert",
 *               "mail": "calvin@gmail.com",
 *               "password": "$2y$10$qQpA4eEfAPCtnZggTJmzney7iU3sSPjsuXic3SjanGUjSZBuXKx4q",
 *               "level": 0,
 *               "refresh_token": "de7b86c5007cb0d7aa63f6db011858f46d7b3e25f793a3db80688f538bb9982e",
 *               "created_at": "2022-03-28 13:38:12",
 *               "updated_at": "2022-03-29 06:55:22",
 *               "inactive": 0
 *           },
 *           "events": [
 *               {
 *                   "id": "1b2a06ba-45ae-4f42-a1c5-67da4490cfd6",
 *                   "creator_id": "56e6b4d6-36aa-49c9-9f0a-dfb6564f52d7",
 *                   "title": "Fête de Calvin",
 *                   "description": "C'est une fête organisé par Calvin",
 *                   "date": "2022-03-08 10:45:00",
 *                   "address": "Nancy 8 Rue De La Faïencerie",
 *                   "lat": 48.69,
 *                   "lon": 6.18372,
 *                   "public": 1,
 *                   "created_at": "2022-03-28 13:40:43",
 *                   "updated_at": "2022-03-28 13:40:43",
 *                   "inactive": 0,
 *               }
 *          ]
 *      }
 *
 */

/**
 *
 * @api {DELETE} /users/:id Supprimer un utilisateur
 * @apiName DeleteUser
 * @apiGroup Users
 *
 * @apiParam  {String} token Token de l'utilisateur
 * @apiParam  {String} id Identifiant de l'utilisateur
 *
 *
 * @apiSuccess {String} response  Message de réponse.
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "response": "User deleted"
 *     }
 *
 */
