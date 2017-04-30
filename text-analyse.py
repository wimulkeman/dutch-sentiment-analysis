# Based on http://www.clips.ua.ac.be/pages/sentiment-analysis-for-dutch
# Documentation at http://www.clips.ua.ac.be/pages/pattern-nl#sentiment
# Installation documentation can be found at https://github.com/clips/pattern

# Import the sentiment analyse module from the pattern module
from pattern.nl import sentiment

neutralText = "Het is een vrij rustige dag."
positiveText = "Het product is mij zeer goed bevallen."
# negativeText = "Het product voldeed niet aan mijn verwachtingen."
negativeText = "Ik ben niet te spreken over de service. Ik verwacht dan ook als compensatie mijn geld terug."

contradictingText = "Dit is een voorbeeld van een overwegend positieve text over een negatief verhaal"

# Classify the text. The function returns 2 values.
# sentiment(text) returns (polarity, subjectivity).
sentimentAnalyse = sentiment(negativeText)

print sentimentAnalyse

# A text is quickly classified as negative. Because of that, we need to
# use a threshold to classify the text as positive, negative, or neutral.
# predictedSentiment = 'positive#' if sentimentAnalyse[0] > 0 else 'negative'
predictedSentiment = 'neutral'
if sentimentAnalyse[0] > 0.4:
    predictedSentiment = 'positive'
elif sentimentAnalyse[0] < -0.2:
    predictedSentiment = 'negative'

predictionSummary = "The provided text is classified as " + str(predictedSentiment) + ' which a score of ' + str(sentimentAnalyse[0])

print predictionSummary